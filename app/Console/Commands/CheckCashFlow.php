<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CheckCashFlow extends Command
{
    protected $signature = 'check:cashflow';

    protected $description = 'Diagnostic for cash flow widget and related data';

    public function handle()
    {
        $this->info('Starting cashflow diagnostics...');

        $this->info('Transactions count: ' . \App\Models\Banking\Transaction::count());
        $this->info('Transactions withTrashed: ' . \App\Models\Banking\Transaction::withTrashed()->count());

        $this->info('Invoices count: ' . \App\Models\Document\Document::invoice()->count());
        $this->info('Invoices sum amount: ' . \App\Models\Document\Document::invoice()->sum('amount'));

        $widget = app(\App\Widgets\CashFlow::class);
        // Ensure filter is set so cache key matches widget behavior
        $widget->setFilter();

        $cacheKey = 'widget.cash_flow.' . company_id() . '.' . $widget->start_date->toDateString() . '.' . $widget->end_date->toDateString() . '.' . $widget->period;

        $cached = Cache::get($cacheKey);

        $this->info('Cache key: ' . $cacheKey . ' present: ' . ($cached ? 'yes' : 'no'));

        if ($cached) {
            $this->info('Cached data preview:');
            $this->line(print_r($cached, true));
        }

        $this->info('Clearing application cache (cache, views, routes, config) and cache facade...');
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        Cache::flush();

        $this->info('Re-rendering widget to compute fresh totals...');

        $view = $widget->show();

        if (method_exists($view, 'getData')) {
            $data = $view->getData();

            $this->info('Widget totals:');
            if (isset($data['totals'])) {
                $this->line(print_r($data['totals'], true));
            } else {
                $this->line('No totals key in view data.');
            }
        } else {
            $this->line('Unable to extract view data from widget show().');
        }

        $this->info('Done.');

        return 0;
    }
}
