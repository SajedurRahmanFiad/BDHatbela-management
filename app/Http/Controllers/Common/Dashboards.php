<?php

namespace App\Http\Controllers\Common;

use App\Abstracts\Http\Controller;
use App\Http\Requests\Common\Dashboard as Request;
use App\Jobs\Common\CreateDashboard;
use App\Jobs\Common\DeleteDashboard;
use App\Jobs\Common\UpdateDashboard;
use App\Models\Common\Dashboard;
use App\Models\Common\Widget;
use App\Traits\DateTime;
use App\Traits\Users;
use App\Utilities\Widgets;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Dashboards extends Controller
{
    use DateTime, Users;

    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Add CRUD permission check
        $this->middleware('permission:create-common-dashboards')->only('create', 'store', 'duplicate', 'import');
        $this->middleware('permission:read-common-dashboards')->only('show');
        $this->middleware('permission:update-common-dashboards')->only('index', 'edit', 'export', 'update', 'enable', 'disable', 'share');
        $this->middleware('permission:delete-common-dashboards')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Eager load users relationship to prevent N+1 queries in dashboard index view
        $dashboards = user()->dashboards()->with('users')->collect();

        return $this->response('common.dashboards.index', compact('dashboards'));
    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @return Response
     */
    public function show($dashboard_id = null)
    {
        $dashboard_id = $dashboard_id ?? session('dashboard_id');

        try {
            $dashboard = Dashboard::findOrFail($dashboard_id);
        } catch (ModelNotFoundException $e) {
            $dashboard = user()->dashboards()->enabled()->first();
        }

        if (empty($dashboard)) {
            // For employees, create a new dashboard with employee invoice summary widget
            if (user()->isEmployee()) {
                $dashboard = $this->dispatch(new CreateDashboard([
                    'company_id' => company_id(),
                    'name' => trans_choice('general.dashboards', 1),
                    'custom_widgets' => [
                        'App\\Widgets\\EmployeeInvoiceSummary' => 'widgets.employee_invoice_summary',
                    ],
                ]));
            } else {
                // For other internal users, keep the existing behavior with core widgets
                $dashboard = $this->dispatch(new CreateDashboard([
                    'company_id' => company_id(),
                    'name' => trans_choice('general.dashboards', 1),
                    'default_widgets' => 'core',
                ]));
            }
        } elseif (user()->isEmployee()) {
            // For employees with existing dashboards, clean up inappropriate widgets
            $inappropriate_widgets = [
                'App\\Widgets\\OrdersSalesSummary',
                'App\\Widgets\\CashFlow',
                'App\\Widgets\\ReceivablesPayables',
                'App\\Widgets\\ProfitLoss',
                'App\\Widgets\\ExpensesByCategory',
            ];

            $widgets_to_remove = Widget::where('dashboard_id', $dashboard->id)
                ->whereIn('class', $inappropriate_widgets)
                ->get();

            foreach ($widgets_to_remove as $widget) {
                $widget->delete();
            }

            // Ensure employee has their invoice summary widget
            $has_employee_widget = Widget::where('dashboard_id', $dashboard->id)
                ->where('class', 'App\\Widgets\\EmployeeInvoiceSummary')
                ->exists();

            if (!$has_employee_widget) {
                $max_sort = Widget::where('dashboard_id', $dashboard->id)->max('sort') ?? 0;
                
                Widget::create([
                    'company_id' => company_id(),
                    'dashboard_id' => $dashboard->id,
                    'class' => 'App\\Widgets\\EmployeeInvoiceSummary',
                    'name' => trans('widgets.employee_invoice_summary'),
                    'sort' => $max_sort + 1,
                    'settings' => ['width' => '100'],
                    'created_from' => 'employee_dashboard',
                    'created_by' => user()->id,
                ]);
            }
        }

        session(['dashboard_id' => $dashboard->id]);

        $widgets = Widget::where('dashboard_id', $dashboard->id)->orderBy('sort', 'asc')->get()->filter(function ($widget) {
            // Check if the widget can be shown based on permissions
            if (!Widgets::canShow($widget->class)) {
                return false;
            }

            // For employee users, hide summary and cash flow widgets
            if (user()->isEmployee()) {
                $hidden_widgets = [
                    'App\\Widgets\\OrdersSalesSummary',
                    'App\\Widgets\\CashFlow',
                    'App\\Widgets\\ReceivablesPayables',
                    'App\\Widgets\\ProfitLoss',
                    'App\\Widgets\\ExpensesByCategory',
                ];

                if (in_array($widget->class, $hidden_widgets)) {
                    return false;
                }
            }

            return true;
        });

        $user_dashboards = user()->dashboards()->enabled()->get();

        $date_picker_shortcuts = $this->getDatePickerShortcuts();

        if (! request()->has('start_date')) {
            request()->merge(['start_date' => $date_picker_shortcuts[trans('general.date_range.this_year')]['start']]);
            request()->merge(['end_date' => $date_picker_shortcuts[trans('general.date_range.this_year')]['end']]);
        }

        return view('common.dashboards.show', compact('dashboard', 'widgets', 'user_dashboards', 'date_picker_shortcuts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Creation of additional dashboards is disabled — return 404
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Creation of additional dashboards is disabled
        return response()->json(['success' => false, 'message' => trans('dashboards.error.disabled')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Dashboard  $dashboard
     *
     * @return Response
     */
    public function edit(Dashboard $dashboard)
    {
        // Editing dashboards has been disabled
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Dashboard  $dashboard
     * @param  $request
     * @return Response
     */
    public function update(Dashboard $dashboard, Request $request)
    {
        // Updating dashboards has been disabled
        return response()->json(['success' => false, 'message' => trans('dashboards.error.disabled')]);
    }

    /**
     * Enable the specified resource.
     *
     * @param  Dashboard $dashboard
     *
     * @return Response
     */
    public function enable(Dashboard $dashboard)
    {
        $response = $this->ajaxDispatch(new UpdateDashboard($dashboard, request()->merge(['enabled' => 1])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.enabled', ['type' => trans_choice('general.dashboards', 1)]);
        }

        return response()->json($response);
    }

    /**
     * Disable the specified resource.
     *
     * @param  Dashboard $dashboard
     *
     * @return Response
     */
    public function disable(Dashboard $dashboard)
    {
        $response = $this->ajaxDispatch(new UpdateDashboard($dashboard, request()->merge(['enabled' => 0])));

        if ($response['success']) {
            $response['message'] = trans('messages.success.disabled', ['type' => trans_choice('general.dashboards', 1)]);
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Dashboard $dashboard
     *
     * @return Response
     */
    public function destroy(Dashboard $dashboard)
    {
        // Deleting dashboards is disabled
        return response()->json(['success' => false, 'message' => trans('dashboards.error.disabled')]);
    }

    /**
     * Change the active dashboard.
     *
     * @param  Dashboard  $dashboard
     *
     * @return Response
     */
    public function switch(Dashboard $dashboard)
    {
        // Switching dashboards is disabled
        return redirect()->route('dashboard');
    }
}
