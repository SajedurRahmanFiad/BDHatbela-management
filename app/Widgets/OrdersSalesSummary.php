<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Log;
use App\Abstracts\Widget;
use App\Models\Document\Document;
use App\Models\Document\DocumentItem;
use App\Models\Common\Item;
use App\Models\Banking\Transaction;
use App\Traits\DateTime;
use App\Utilities\Date;
use Akaunting\Apexcharts\Chart;
use App\Traits\Charts;
use App\Traits\Currencies;

class OrdersSalesSummary extends Widget
{
    use Charts, Currencies, DateTime;

    public $default_name = 'widgets.orders_sales_summary';

    public $default_settings = [
        'width' => '100',
    ];

    public $description = 'widgets.description.orders_sales_summary';

    public $start_date;
    public $end_date;
    public $period_type;
    public $period; // Added to fix "Undefined property" error

    public function show()
    {
        // 1. MUST RUN FILTER FIRST to establish dates
        $this->setFilter();

        // 2. Calculate metrics for the summary using completed documents only
        // NOTE: "Completed" here means paid invoices/bills.

        // DEBUG: Dump model structure
        Log::debug('OrdersSalesSummary model', [
            'model' => json_decode(json_encode($this->model), true)
        ]);

        // Ensure model properties exist for the view
        if (is_object($this->model)) {
            if (!property_exists($this->model, 'name')) {
                $this->model->name = trans('widgets.orders_sales_summary');
            }
            if (!property_exists($this->model, 'settings') || !is_object($this->model->settings)) {
                $this->model->settings = (object)[];
            }
            if (!property_exists($this->model->settings, 'raw_width')) {
                $this->model->settings->raw_width = '25';
            }
            if (!property_exists($this->model->settings, 'width')) {
                $this->model->settings->width = '100';
            }
        }

        // Calculate Single Totals for the Summary Boxes
        // Total orders: include all invoices in the period, regardless of status
        $total_orders = Document::invoice()
            ->whereBetween('issued_at', [$this->start_date, $this->end_date])
            ->count();

        // Orders by workflow state
        $processing_orders = Document::invoice()
            ->whereIn('status', ['sent', 'viewed', 'partial'])
            ->whereBetween('issued_at', [$this->start_date, $this->end_date])
            ->count();

        $picked_orders = Document::invoice()
            ->where('status', 'picked')
            ->whereBetween('issued_at', [$this->start_date, $this->end_date])
            ->count();

        // Completed orders (paid invoices) in this period
        $completed_orders = Document::invoice()
            ->where('status', 'paid')
            ->whereBetween('issued_at', [$this->start_date, $this->end_date])
            ->count();

        // Total sales: income from sales category
        $sales_category_id = setting('default.income_category');
        $total_sales_amount = Transaction::income()
            ->where('category_id', $sales_category_id)
            ->whereBetween('paid_at', [$this->start_date, $this->end_date])
            ->isNotTransfer()
            ->get()
            ->sum(function ($transaction) {
                return $transaction->getAmountConvertedToDefault();
            });

        // Total purchases: completed (paid) bills in the period
        $total_purchases_amount = Document::bill()
            ->where('status', 'paid')
            ->whereBetween('issued_at', [$this->start_date, $this->end_date])
            ->sum('amount');

        // Total income: sum of all income transactions (non-transfer)
        $income_transactions = Transaction::income()
            ->whereBetween('paid_at', [$this->start_date, $this->end_date])
            ->isNotTransfer()
            ->get();

        $total_income_amount = 0;
        foreach ($income_transactions as $transaction) {
            $total_income_amount += $transaction->getAmountConvertedToDefault();
        }

        // Total expenses: sum of all expense transactions across all expense categories (non-transfer)
        $expense_transactions = Transaction::expense()
            ->whereBetween('paid_at', [$this->start_date, $this->end_date])
            ->isNotTransfer()
            ->get();

        $total_expenses_amount = 0;
        foreach ($expense_transactions as $transaction) {
            $total_expenses_amount += $transaction->getAmountConvertedToDefault();
        }

        // Other expenses: total expenses minus purchase expenses
        $other_expenses_amount = $total_expenses_amount - $total_purchases_amount;

        // Profit: total income - total expenses
        $total_profit_amount = $total_income_amount - $total_expenses_amount;

        // Format amounts
        $total_sales = money($total_sales_amount);
        $total_purchases = money($total_purchases_amount);
        $total_income = money($total_income_amount);
        $other_expenses = money($other_expenses_amount);
        $total_expenses = money($total_expenses_amount);
        $total_profit = money($total_profit_amount);

        $data = [
            'total_orders' => $total_orders,
            'processing_orders' => $processing_orders,
            'picked_orders' => $picked_orders,
            'completed_orders' => $completed_orders,

            'total_sales_exact' => $total_sales->format(),
            'total_sales_for_humans' => $total_sales->formatForHumans(),

            'total_purchases_exact' => $total_purchases->format(),
            'total_purchases_for_humans' => $total_purchases->formatForHumans(),

            'total_income_exact' => $total_income->format(),
            'total_income_for_humans' => $total_income->formatForHumans(),

            'other_expenses_exact' => $other_expenses->format(),
            'other_expenses_for_humans' => $other_expenses->formatForHumans(),

            'total_expenses_exact' => $total_expenses->format(),
            'total_expenses_for_humans' => $total_expenses->formatForHumans(),

            'total_profit_amount' => $total_profit_amount,
            'total_profit_exact' => $total_profit->format(),
            'total_profit_for_humans' => $total_profit->formatForHumans(),

            'period_type' => $this->period_type,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
        ];

        return $this->view('widgets.orders_sales_summary', $data);
    }

    public function setFilter(): void
    {
        $this->period_type = request('period_type', 'today');
        
        // Map period_type to the 'period' variable used by calculateTotals
        $this->period = ($this->period_type == 'last_year') ? 'quarter' : 'month';

        $today = Date::today();

        if (request()->has('start_date') || request()->has('end_date')) {
            $this->period_type = 'custom';
            $start = request('start_date', $today->toDateString());
            $end = request('end_date', $today->toDateString());
            $this->start_date = Date::parse($start)->startOfDay();
            $this->end_date = Date::parse($end)->endOfDay();
            return;
        }

        switch ($this->period_type) {
            case 'today':
                $this->start_date = $today->copy()->startOfDay();
                $this->end_date = $today->copy()->endOfDay();
                break;
            case 'last_week':
                $this->start_date = $today->copy()->subWeek()->startOfWeek();
                $this->end_date = $today->copy()->subWeek()->endOfWeek();
                break;
            case 'last_month':
                $this->start_date = $today->copy()->subMonth()->startOfMonth();
                $this->end_date = $today->copy()->subMonth()->endOfMonth();
                break;
            case 'last_year':
                $this->start_date = $today->copy()->subYear()->startOfYear();
                $this->end_date = $today->copy()->subYear()->endOfYear();
                break;
            default:
                $this->start_date = $today->copy()->startOfDay();
                $this->end_date = $today->copy()->endOfDay();
                break;
        }
    }

    private function calculateTotals($type): array
    {
        $totals = [];
        $date_format = 'Y-m';
        $n = ($this->period == 'month') ? 1 : 3;
        
        $s = clone $this->start_date;
        $current = clone $this->start_date;

        // Initialize the array keys
        while ($current <= $this->end_date) {
            $key = ($this->period == 'month') ? $current->format($date_format) : $current->quarter;
            $totals[$key] = 0;
            $current->addMonths($n);
            if ($this->period != 'month' && count($totals) >= 4) break;
        }

        // Note: Removed applyFilters because it doesn't exist in this widget class
        $items = Transaction::$type()
            ->whereBetween('paid_at', [$this->start_date, $this->end_date])
            ->isNotTransfer()
            ->get();

        $this->setTotals($totals, $items, $date_format);
        return $totals;
    }

    private function setTotals(&$totals, $items, $date_format): void
    {
        $type = 'income';
        foreach ($items as $item) {
            $type = $item->type;
            $i = ($this->period == 'month') ? Date::parse($item->paid_at)->format($date_format) : Date::parse($item->paid_at)->quarter;

            if (isset($totals[$i])) {
                $totals[$i] += $item->getAmountConvertedToDefault();
            }
        }

        $precision = currency()->getPrecision();
        foreach ($totals as $key => $value) {
            if ($type == 'expense') $value = -1 * $value;
            $totals[$key] = round($value, $precision);
        }
    }

    // The following helper methods (calculateCogsTotals, calculateShippingTotals, calculateProfit)
    // remain for potential future use but are no longer used by the summary totals above.

    private function calculateCogsTotals(): array
    {
        $totals = [];
        $date_format = 'Y-m';
        $n = ($this->period == 'month') ? 1 : 3;
        $current = clone $this->start_date;

        while ($current <= $this->end_date) {
            $key = ($this->period == 'month') ? $current->format($date_format) : $current->quarter;
            $totals[$key] = 0;
            $current->addMonths($n);
            if ($this->period != 'month' && count($totals) >= 4) break;
        }

        $invoices = Document::invoice()
            ->whereBetween('issued_at', [$this->start_date, $this->end_date])
            ->with('items.item')
            ->get();

        foreach ($invoices as $invoice) {
            $i = ($this->period == 'month') ? Date::parse($invoice->issued_at)->format($date_format) : Date::parse($invoice->issued_at)->quarter;
            if (!isset($totals[$i])) continue;

            foreach ($invoice->items as $line) {
                $purchase_price = $line->purchase_price ?? $line->item->purchase_price ?? 0;
                $quantity = $line->quantity ?? 0;
                $totals[$i] += ($purchase_price * $quantity);
            }
        }

        $precision = currency()->getPrecision();
        foreach ($totals as $key => $value) {
            $totals[$key] = round($value, $precision);
        }
        return $totals;
    }

    private function calculateShippingTotals(): array
    {
        $totals = [];
        $date_format = 'Y-m';
        $n = ($this->period == 'month') ? 1 : 3;
        $current = clone $this->start_date;

        while ($current <= $this->end_date) {
            $key = ($this->period == 'month') ? $current->format($date_format) : $current->quarter;
            $totals[$key] = 0;
            $current->addMonths($n);
            if ($this->period != 'month' && count($totals) >= 4) break;
        }

        $invoices = Document::invoice()
            ->whereBetween('issued_at', [$this->start_date, $this->end_date])
            ->get();

        foreach ($invoices as $invoice) {
            $i = ($this->period == 'month') ? Date::parse($invoice->issued_at)->format($date_format) : Date::parse($invoice->issued_at)->quarter;
            if (!isset($totals[$i])) continue;

            $shipping = (float) ($invoice->shipping ?? $invoice->totals()->code('shipping')->sum('amount'));
            if ($shipping <= 0) continue;

            $shipping_converted = $invoice->convertToDefault($shipping, $invoice->currency_code, $invoice->currency_rate);

            $totals[$i] += $shipping_converted;
        }

        $precision = currency()->getPrecision();
        foreach ($totals as $key => $value) {
            $totals[$key] = round($value, $precision);
        }
        return $totals;
    }

    private function calculateProfit($incomes, $expenses, $cogs = []): array
    {
        $profit = [];
        $precision = currency()->getPrecision();
        foreach ($incomes as $key => $income) {
            $expense_value = $expenses[$key] ?? 0;
            $value = $income - abs($expense_value);
            $profit[$key] = round($value, $precision);
        }
        return $profit;
    }
}