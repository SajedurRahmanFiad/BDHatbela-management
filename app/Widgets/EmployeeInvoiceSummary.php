<?php

namespace App\Widgets;

use Illuminate\Support\Facades\Auth;
use App\Abstracts\Widget;
use App\Models\Document\Document;

class EmployeeInvoiceSummary extends Widget
{
    public $default_name = 'widgets.employee_invoice_summary';

    public $default_settings = [
        'width' => '100',
    ];

    public $description = 'widgets.description.employee_invoice_summary';

    public $start_date;
    public $end_date;
    public $period_type;

    public function show()
    {
        $this->setFilter();

        $user = Auth::user();

        $total_invoices = Document::invoice()
            ->where('created_by', $user->id)
            ->count();

        $today = now()->startOfDay();
        $today_invoices = Document::invoice()
            ->where('created_by', $user->id)
            ->where('created_at', '>=', $today)
            ->count();

        $pending_invoices = Document::invoice()
            ->where('created_by', $user->id)
            ->where('status', 'draft')
            ->count();

        $data = [
            'total_invoices' => $total_invoices,
            'today_invoices' => $today_invoices,
            'pending_invoices' => $pending_invoices,
        ];

        return $this->view('widgets.employee_invoice_summary', $data);
    }

    public function setFilter(): void
    {
        $this->period_type = request('period_type', 'today');
        $today = today();

        if (request()->has('start_date') || request()->has('end_date')) {
            $this->period_type = 'custom';
            $start = request('start_date', $today->toDateString());
            $end = request('end_date', $today->toDateString());
            $this->start_date = \App\Utilities\Date::parse($start)->startOfDay();
            $this->end_date = \App\Utilities\Date::parse($end)->endOfDay();
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
}
