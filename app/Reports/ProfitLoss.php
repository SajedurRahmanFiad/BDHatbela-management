<?php

namespace App\Reports;

use App\Abstracts\Report;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Utilities\Recurring;
use App\Utilities\Date;

class ProfitLoss extends Report
{
    public $default_name = 'reports.profit_loss';

    public $category = 'general.accounting';

    public $icon = 'favorite_border';

    public $type = 'detail';

    public $chart = false;

    public function setViews()
    {
        parent::setViews();
        $this->views['detail.content.header'] = 'reports.profit_loss.content.header';
        $this->views['detail.content.footer'] = 'reports.profit_loss.content.footer';
        $this->views['detail.table.header'] = 'reports.profit_loss.table.header';
        $this->views['detail.table.footer'] = 'reports.profit_loss.table.footer';
    }

    public function setTables()
    {
        $this->tables = [
            'income' => trans_choice('general.incomes', 1),
            'expense' => trans_choice('general.expenses', 2),
        ];
    }

    public function setData()
    {
        $income_transactions = $this->applyFilters(Transaction::with('recurring')->income()->isNotTransfer(), ['date_field' => 'paid_at']);
        $expense_transactions = $this->applyFilters(Transaction::with('recurring')->expense()->isNotTransfer(), ['date_field' => 'paid_at']);

        switch ($this->getBasis()) {
            case 'cash':
                // Incomes
                $incomes = $income_transactions->get();
                $this->setTotals($incomes, 'paid_at', false, 'income', false);

                // Add COGS for cash basis (align COGS to transaction paid date)
                $this->addCogsToFooterTotals($incomes, 'paid_at');

                // Subtract invoice shipping from net profit by adding shipping to expenses (cash basis)
                $this->addShippingToFooterTotals($incomes, 'paid_at');

                // Expenses
                $expenses = $expense_transactions->get();
                $this->setTotals($expenses, 'paid_at', false, 'expense', false);

                break;
            default:
                // Invoices
                $invoices = $this->applyFilters(Document::invoice()->with('recurring', 'totals', 'transactions', 'items')->accrued(), ['date_field' => 'issued_at'])->get();
                Recurring::reflect($invoices, 'issued_at');
                $this->setTotals($invoices, 'issued_at', false, 'income', false);

                // Add COGS for accrual basis (align COGS to invoice issued date)
                $this->addCogsToFooterTotals($invoices, 'issued_at');

                // Subtract invoice shipping from net profit by adding shipping to expenses
                $this->addShippingToFooterTotals($invoices, 'issued_at');

                // Incomes
                $incomes = $income_transactions->isNotDocument()->get();
                Recurring::reflect($incomes, 'paid_at');
                $this->setTotals($incomes, 'paid_at', false, 'income', false);

                // Bills
                $bills = $this->applyFilters(Document::bill()->with('recurring', 'totals', 'transactions', 'items')->accrued(), ['date_field' => 'issued_at'])->get();
                Recurring::reflect($bills, 'issued_at');
                $this->setTotals($bills, 'issued_at', false, 'expense', false);

                // Expenses
                $expenses = $expense_transactions->isNotDocument()->get();
                Recurring::reflect($expenses, 'paid_at');
                $this->setTotals($expenses, 'paid_at', false, 'expense', false);

                break;
        }

        $this->setNetProfit();

        // COGS totals are stored separately and are excluded from net profit calculation
    }

    private function addCogsToFooterTotals($items, $date_field): void
    {
        $processed = [];

        foreach ($items as $item) {
            // Determine the document (either the item itself or a related document on a transaction)
            if ($item instanceof Document) {
                $doc = $item;
                $date_source = $item->$date_field;
            } elseif (isset($item->document) && $item->document) {
                $doc = $item->document;
                $date_source = $item->$date_field;
            } else {
                continue;
            }

            if (in_array($doc->id, $processed)) {
                continue;
            }

            $cogs = 0;

            foreach ($doc->items as $line) {
                $purchase_price = $line->purchase_price ?? $line->item->purchase_price ?? 0;
                $quantity = $line->quantity ?? 0;

                if ($purchase_price > 0 && $quantity > 0) {
                    $cogs += $purchase_price * $quantity;
                }
            }

            if ($cogs == 0) {
                $processed[] = $doc->id;

                continue;
            }

            $date = $this->getPeriodicDate(Date::parse($date_source), $this->getPeriod(), $this->year);

            if (!isset($this->footer_totals['cogs'][$date])) {
                $this->footer_totals['cogs'][$date] = 0;
            }

            $this->footer_totals['cogs'][$date] += $cogs; 

            $processed[] = $doc->id;
        }
    }

    /**
     * Add invoice shipping totals into expenses so shipping will reduce net profit
     * while still being shown in income (sales).
     */
    private function addShippingToFooterTotals($items, $date_field): void
    {
        $processed = [];

        foreach ($items as $item) {
            // Determine the document (either the item itself or a related document on a transaction)
            if ($item instanceof Document) {
                $doc = $item;
                $date_source = $item->$date_field;
            } elseif (isset($item->document) && $item->document) {
                $doc = $item->document;
                $date_source = $item->$date_field;
            } else {
                continue;
            }

            if (in_array($doc->id, $processed)) {
                continue;
            }

            // Sum shipping totals for this document (prefer value stored on document, fallback to totals)
            $shipping = (float) ($doc->shipping ?? $doc->totals()->code('shipping')->sum('amount'));

            if ($shipping <= 0) {
                $processed[] = $doc->id;

                continue;
            }

            // Convert shipping amount to default currency of report using document's conversion
            $shipping_converted = $doc->convertToDefault($shipping, $doc->currency_code, $doc->currency_rate);

            $date = $this->getPeriodicDate(Date::parse($date_source), $this->getPeriod(), $this->year);

            if (!isset($this->footer_totals['expense'][$date])) {
                $this->footer_totals['expense'][$date] = 0;
            }

            $this->footer_totals['expense'][$date] += $shipping_converted;

            $processed[] = $doc->id;
        }
    }

    public function setNetProfit()
    {
        foreach ($this->footer_totals as $table => $dates) {
            foreach ($dates as $date => $total) {
                if (!isset($this->net_profit[$date])) {
                    $this->net_profit[$date] = 0;
                }

                if ($table == 'income') {
                    $this->net_profit[$date] += $total;
                    continue;
                }

                if ($table == 'expense') {
                    $this->net_profit[$date] -= $total;
                }

            }
        }
    }

    public function array(): array
    {
        $data = parent::array();

        $net_profit = $this->net_profit;

        if ($this->has_money) {
            $net_profit = array_map(fn($value) => money($value)->format(), $net_profit);
        }

        $data['net_profit'] = $net_profit;

        return $data;
    }
}
