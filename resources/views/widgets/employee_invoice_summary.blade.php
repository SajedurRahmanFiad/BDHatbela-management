<div id="widget-{{ $class->model->id }}" class="w-full my-5 px-1">

    <div class="flex flex-col gap-6 mt-5 md:flex-row md:items-stretch">
        <div class="flex-1 min-w-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.total_invoices') }}</p>
                    <h3 class="text-4xl font-bold">{{ $total_invoices }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">receipt_long</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.all_time_invoices') }}</p>
            </div>
        </div>

        <div class="flex-1 min-w-0 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.today_invoices') }}</p>
                    <h3 class="text-4xl font-bold">{{ $today_invoices }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">today</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.invoices_created_today') }}</p>
            </div>
        </div>

        <div class="flex-1 min-w-0 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium opacity-90 mb-1">{{ trans('widgets.pending_invoices') }}</p>
                    <h3 class="text-4xl font-bold">{{ $pending_invoices }}</h3>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <span class="material-icons text-4xl">hourglass_top</span>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white border-opacity-20">
                <p class="text-xs opacity-75">{{ trans('widgets.awaiting_approval') }}</p>
            </div>
        </div>
    </div>
</div>
