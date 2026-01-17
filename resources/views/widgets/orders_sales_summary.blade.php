<div id="widget-{{ $class->model->id }}" class="w-full my-5 px-1">

    <!-- First row: four metric boxes (totals) -->
    <div class="flex flex-col gap-6 mt-5 md:flex-row md:items-stretch">
        <!-- Total Sales Box -->
        <div class="flex-1 min-w-0 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.total_sales') }}</p>
                    <x-tooltip id="tooltip-sales-{{ $class->model->id }}" placement="top" message="{{ $total_sales_exact }}">
                        <h3 class="text-4xl font-bold">{{ $total_sales_for_humans }}</h3>
                    </x-tooltip>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">attach_money</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.revenue_from_invoices') }}</p>
            </div>
        </div>

        <!-- Total Purchases Box -->
        <div class="flex-1 min-w-0 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.total_purchases') }}</p>
                    <x-tooltip id="tooltip-purchases-{{ $class->model->id }}" placement="top" message="{{ $total_purchases_exact }}">
                        <h3 class="text-4xl font-bold">{{ $total_purchases_for_humans }}</h3>
                    </x-tooltip>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">inventory_2</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.purchases_from_bills') }}</p>
            </div>
        </div>

        <!-- Other Expenses -->
        <div class="flex-1 min-w-0 bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.other_expenses') }}</p>
                    <x-tooltip id="tooltip-expenses-{{ $class->model->id }}" placement="top" message="{{ $other_expenses_exact }}">
                        <h3 class="text-4xl font-bold">{{ $other_expenses_for_humans }}</h3>
                    </x-tooltip>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">payments</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.other_expenses_plus_shipping') }}</p>
            </div>
        </div>

        <!-- Total Profit Box -->
        <div class="flex-1 min-w-0 bg-gray-800 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.total_profit') }}</p>
                    <x-tooltip id="tooltip-profit-{{ $class->model->id }}" placement="top" message="{{ $total_profit_exact }}">
                        <h3 class="text-4xl font-bold {{ $total_profit_amount >= 0 ? 'text-green-400' : 'text-red-400' }}">{{ $total_profit_for_humans }}</h3>
                    </x-tooltip>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">trending_up</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.sales_minus_expenses') }}</p>
            </div>
        </div>
    </div>

    <!-- Second row: order counts (statuses) -->
    <div class="flex flex-col gap-6 mt-6 md:flex-row md:items-stretch">
        <!-- Total Orders Box -->
        <div class="flex-1 min-w-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.total_orders') }}</p>
                    <h3 class="text-4xl font-bold">{{ $total_orders }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">shopping_cart</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.includes_draft_sent_paid') }}</p>
            </div>
        </div>

        <!-- Processing Orders -->
        <div class="flex-1 min-w-0 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.processing_orders') }}</p>
                    <h3 class="text-4xl font-bold">{{ $processing_orders }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">hourglass_top</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.orders_in_processing_states') }}</p>
            </div>
        </div>

        <!-- Picked Orders -->
        <div class="flex-1 min-w-0 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.picked_orders') }}</p>
                    <h3 class="text-4xl font-bold">{{ $picked_orders }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">inventory</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.orders_marked_picked') }}</p>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="flex-1 min-w-0 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.completed_orders') }}</p>
                    <h3 class="text-4xl font-bold">{{ $completed_orders }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">check_circle</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.orders_marked_completed') }}</p>
            </div>
        </div>
    </div>
</div>

