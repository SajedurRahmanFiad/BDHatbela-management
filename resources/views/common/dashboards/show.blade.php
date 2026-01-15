<x-layouts.admin>
    <x-slot name="metaTitle">
        {{ $dashboard->name }}
    </x-slot>

    <x-slot name="title">
        {{ $dashboard->name }}
    </x-slot>

    <x-slot name="buttons">
        <!--Dashboard General Filter-->
        <el-date-picker
            v-model="filter_date"
            type="daterange"
            align="right"
            unlink-panels
            format="yyyy-MM-dd"
            value-format="yyyy-MM-dd"
            @change="onChangeFilterDate"
            range-separator="-"
            start-placeholder="{{ $date_picker_shortcuts[trans('general.date_range.this_year')]['start'] }}"
            end-placeholder="{{ $date_picker_shortcuts[trans('general.date_range.this_year')]['end'] }}"
            popper-class="dashboard-picker"
            :picker-options="{
                shortcuts: [
                    @foreach ($date_picker_shortcuts as $text => $shortcut)
                        {
                            text: `{!! $text !!}`,
                            onClick(picker) {
                                const start = new Date('{{ $shortcut["start"] }}');
                                const end = new Date('{{ $shortcut["end"] }}');

                                picker.$emit('pick', [start, end]);
                            }
                        },
                    @endforeach
                ]
            }">
        </el-date-picker>
    </x-slot>



    <x-slot name="content">
        <div class="flex flex-col lg:flex-row justify-between items-start border-b pt-8">
            <div class="flex">
                {{-- Multiple dashboards removed — only a single fixed dashboard is used. --}}
            </div>

            <div class="flex col-span-3 ml-6 text-right">
            </div> 
        </div>

        {{-- Top summary widget: Only show for non-employee users --}}
        @if(! user()->isEmployee())
        <div class="px-6 lg:-mx-12">
            @php
                $ordersSalesSummaryModel = (object) [
                    'id' => 'orders_sales_summary',
                    'settings' => (object) [
                        'width' => '100',
                        'raw_width' => '25',
                    ],
                ];
            @endphp
            {!! (new \App\Widgets\OrdersSalesSummary($ordersSalesSummaryModel))->show() !!}
        </div>

        {{-- Cash Flow widget: place directly below Orders/Sales Summary --}}
        <div class="px-6 lg:-mx-12">
            {!! (new \App\Widgets\CashFlow((object)['id' => 'cash_flow', 'settings' => (object)['width' => '100']]))->show() !!}
        </div>
        @else
        {{-- Employee invoice summary widget --}}
        <div class="px-6 lg:-mx-12">
            @php
                $employeeInvoiceSummaryModel = (object) [
                    'id' => 'employee_invoice_summary',
                    'settings' => (object) [
                        'width' => '100',
                        'raw_width' => '25',
                    ],
                ];
            @endphp
            {!! (new \App\Widgets\EmployeeInvoiceSummary($employeeInvoiceSummaryModel))->show() !!}
        </div>
        @endif

        <div class="dashboard flex flex-wrap px-6 lg:-mx-12">
            @foreach($widgets as $widget)
                @if(! isset($widget->class) || ! in_array($widget->class, ['App\\Widgets\\CashFlow', 'App\\Widgets\\OrdersSalesSummary']))
                    @widget($widget)
                @endif
            @endforeach
        </div>
    </x-slot>

    <x-script folder="common" file="dashboards" />
</x-layouts.admin>
