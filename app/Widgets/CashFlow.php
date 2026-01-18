<?php

namespace App\Widgets;

use Akaunting\Apexcharts\Chart;
use App\Abstracts\Widget;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Traits\Charts;
use App\Traits\Currencies;
use App\Traits\DateTime;
use App\Utilities\Date;
use Illuminate\Support\Facades\Cache;

class CashFlow extends Widget
{
    use Charts, Currencies, DateTime;

    public $default_name = 'widgets.cash_flow';

    public $default_settings = [
        'width' => '100',
    ];

    public $description = 'widgets.description.cash_flow';

    public $report_class = 'Modules\CashFlowStatement\Reports\CashFlowStatement';

    public $start_date;

    public $end_date;

    public $period;

    public function show()
    {
        $this->setFilter();
        $cacheKey = 'widget.cash_flow.' . company_id() . '.' . $this->start_date->toDateString() . '.' . $this->end_date->toDateString() . '.' . $this->period;

        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () {
            $income = array_values($this->calculateTotals('income'));
            $expense = array_values($this->calculateTotals('expense'));
            // Calculate COGS per period (available separately; not subtracted from profit)
            $cogs = array_values($this->calculateCogsTotals());
            // Shipping is included in incoming totals via invoices/payments and should not be treated as outgoing
            // (previously shipping was subtracted from expenses, causing shipping to show as outgoing)
            $profit = array_values($this->calculateProfit($income, $expense, $cogs));

            return compact('income', 'expense', 'cogs', 'profit');
        });

        $income = $data['income'];
        $expense = $data['expense'];
        $cogs = $data['cogs'];
        $profit = $data['profit'];

        $chart = new Chart();

        $chart->setType('line')
            ->setDefaultLocale($this->getDefaultLocaleOfChart())
            ->setLocales($this->getLocaleTranslationOfChart())
            ->setStacked(true)
            ->setBar(['columnWidth' => '40%'])
            ->setLegendPosition('top')
            ->setYaxisLabels(['formatter' => $this->getChartLabelFormatter()])
            ->setLabels(array_values($this->getLabels()))
            ->setColors($this->getColors())
            ->setDataset(trans('general.incoming'), 'column', $income)
            ->setDataset(trans('general.outgoing'), 'column', $expense)
            ->setDataset(trans_choice('general.profits', 1), 'line', $profit);

        $incoming_amount = money(array_sum($income));
        $outgoing_amount = money(abs(array_sum($expense)));
        $profit_amount = money(array_sum($profit));

        $totals = [
            'incoming_exact'        => $incoming_amount->format(),
            'incoming_for_humans'   => $incoming_amount->formatForHumans(),
            'outgoing_exact'        => $outgoing_amount->format(),
            'outgoing_for_humans'   => $outgoing_amount->formatForHumans(),
            'profit_exact'          => $profit_amount->format(),
            'profit_for_humans'     => $profit_amount->formatForHumans(),
        ];

        return $this->view('widgets.cash_flow', [
            'chart' => $chart,
            'totals' => $totals,
        ]);
    }

    public function setFilter(): void
    {
        $financial_year = $this->getFinancialYear();

        $this->start_date = Date::parse(request('start_date', $financial_year->copy()->getStartDate()->toDateString()))->startOfDay();
        $this->end_date = Date::parse(request('end_date', $financial_year->copy()->getEndDate()->toDateString()))->endOfDay();
        $this->period = request('period', 'month');
    }

    public function getLabels(): array
    {
        $labels = [];

        $start_date = $this->start_date->copy();

        $counter = $this->end_date->diffInMonths($this->start_date);

        for ($j = 0; $j <= $counter; $j++) {
            $labels[$j] = $start_date->format($this->getMonthlyDateFormat());

            if ($this->period == 'month') {
                $start_date->addMonth();
            } else {
                $start_date->addMonths(3);
                $j += 2;
            }
        }

        return $labels;
    }

    public function getColors(): array
    {
        return [
            '#8bb475',
            '#fb7185',
            '#7779A2',
        ];
    }

    private function calculateTotals($type): array
    {
        $totals = [];

        $date_format = 'Y-m';

        if ($this->period == 'month') {
            $n = 1;
            $start_date = $this->start_date->format($date_format);
            $end_date = $this->end_date->format($date_format);
            $next_date = $start_date;
        } else {
            $n = 3;
            $start_date = $this->start_date->quarter;
            $end_date = $this->end_date->quarter;
            $next_date = $start_date;
        }

        $s = clone $this->start_date;

        //$totals[$start_date] = 0;
        while ($next_date <= $end_date) {
            $totals[$next_date] = 0;

            if ($this->period == 'month') {
                $next_date = $s->addMonths($n)->format($date_format);
            } else {
                if (isset($totals[4])) {
                    break;
                }

                $next_date = $s->addMonths($n)->quarter;
            }
        }

        $items = $this->applyFilters(Transaction::$type()->whereBetween('paid_at', [$this->start_date, $this->end_date])->isNotTransfer())->get();

        $this->setTotals($totals, $items, $date_format);

        return $totals;
    }

    private function setTotals(&$totals, $items, $date_format): void
    {
        $type = 'income';

        foreach ($items as $item) {
            $type = $item->type;

            if ($this->period == 'month') {
                $i = Date::parse($item->paid_at)->format($date_format);
            } else {
                $i = Date::parse($item->paid_at)->quarter;
            }

            if (!isset($totals[$i])) {
                continue;
            }

            $totals[$i] += $item->getAmountConvertedToDefault();
        }

        $precision = currency()->getPrecision();

        foreach ($totals as $key => $value) {
            if ($type == 'expense') {
                $value = -1 * $value;
            }

            $totals[$key] = round($value, $precision);
        }
    }

    private function calculateCogsTotals(): array
    {
        $totals = [];

        $date_format = 'Y-m';

        if ($this->period == 'month') {
            $n = 1;
            $start_date = $this->start_date->format($date_format);
            $end_date = $this->end_date->format($date_format);
            $next_date = $start_date;
        } else {
            $n = 3;
            $start_date = $this->start_date->quarter;
            $end_date = $this->end_date->quarter;
            $next_date = $start_date;
        }

        $s = clone $this->start_date;

        while ($next_date <= $end_date) {
            $totals[$next_date] = 0;

            if ($this->period == 'month') {
                $next_date = $s->addMonths($n)->format($date_format);
            } else {
                if (isset($totals[4])) {
                    break;
                }

                $next_date = $s->addMonths($n)->quarter;
            }
        }

        $invoices = Document::invoice()->whereBetween('issued_at', [$this->start_date, $this->end_date])->with('items.item')->get();

        foreach ($invoices as $invoice) {
            if ($this->period == 'month') {
                $i = Date::parse($invoice->issued_at)->format($date_format);
            } else {
                $i = Date::parse($invoice->issued_at)->quarter;
            }

            if (!isset($totals[$i])) {
                continue;
            }

            foreach ($invoice->items as $line) {
                $purchase_price = $line->purchase_price ?? $line->item->purchase_price ?? 0;
                $quantity = $line->quantity ?? 0;

                if ($purchase_price == 0 || $quantity == 0) {
                    continue;
                }

                // purchase_price stored in default currency; sum directly
                $totals[$i] += $purchase_price * $quantity;
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

        if ($this->period == 'month') {
            $n = 1;
            $start_date = $this->start_date->format($date_format);
            $end_date = $this->end_date->format($date_format);
            $next_date = $start_date;
        } else {
            $n = 3;
            $start_date = $this->start_date->quarter;
            $end_date = $this->end_date->quarter;
            $next_date = $start_date;
        }

        $s = clone $this->start_date;

        while ($next_date <= $end_date) {
            $totals[$next_date] = 0;

            if ($this->period == 'month') {
                $next_date = $s->addMonths($n)->format($date_format);
            } else {
                if (isset($totals[4])) {
                    break;
                }

                $next_date = $s->addMonths($n)->quarter;
            }
        }

        $invoices = Document::invoice()->whereBetween('issued_at', [$this->start_date, $this->end_date])->get();

        foreach ($invoices as $invoice) {
            if ($this->period == 'month') {
                $i = Date::parse($invoice->issued_at)->format($date_format);
            } else {
                $i = Date::parse($invoice->issued_at)->quarter;
            }

            if (!isset($totals[$i])) {
                continue;
            }

            $shipping = (float) ($invoice->shipping ?? $invoice->totals()->code('shipping')->sum('amount'));

            if ($shipping <= 0) {
                continue;
            }

            // Convert shipping amount to default currency
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

        // Include shipping charges in profit calculation: shipping is part of sales/incoming
        $periodCount = max(count($incomes), count($expenses));

        for ($i = 0; $i < $periodCount; $i++) {
            $income = $incomes[$i] ?? 0;
            $expense_value = $expenses[$i] ?? 0;

            // Shipping is counted as part of income; do not subtract it from profit
            $value = $income - abs($expense_value);

            $profit[$i] = round($value, $precision);
        }

        return $profit;
    }
}
