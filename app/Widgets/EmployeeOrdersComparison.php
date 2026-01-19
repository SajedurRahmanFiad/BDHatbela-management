<?php

namespace App\Widgets;

use Illuminate\Support\Facades\DB;
use App\Abstracts\Widget;
use App\Models\Document\Document;
use App\Models\Auth\User;

class EmployeeOrdersComparison extends Widget
{
    public $default_name = 'widgets.employee_orders_comparison';

    public $default_settings = [
        'width' => '100',
    ];

    public $description = 'widgets.description.employee_orders_comparison';

    public $start_date;
    public $end_date;
    public $period_type;

    public function show()
    {
        $start_date = request('start_date');
        $end_date = request('end_date');

        if (!$start_date || !$end_date) {
            // Default to current month or something
            $start_date = now()->startOfMonth()->toDateString();
            $end_date = now()->endOfMonth()->toDateString();
        }

        $this->start_date = \App\Utilities\Date::parse($start_date)->startOfDay();
        $this->end_date = \App\Utilities\Date::parse($end_date)->endOfDay();

        $orders = Document::invoice()
            ->whereBetween('created_at', [$this->start_date, $this->end_date])
            ->select('created_by', DB::raw('count(*) as count'))
            ->groupBy('created_by')
            ->orderBy('count', 'desc')
            ->get();

        $users = [];
        $counts = [];

        foreach ($orders as $order) {
            $user = User::find($order->created_by);
            if ($user) {
                $users[] = $user->name;
                $counts[] = $order->count;
            }
        }

        $data = [
            'users' => $users,
            'counts' => $counts,
        ];

        return $this->view('widgets.employee_orders_comparison', $data);
    }
}