<div class="pb-2 my-4 lg:my-0{{ !empty($header_class) ? ' ' . $header_class : '' }}">
    <div class="flex justify-between font-medium mb-2">
        <h2 class="text-black" title="{{ $class->model->name }}">
            {{ $class->model->name }}
        </h2>

        <div class="flex items-center">
            @if ($report = $class->getReportUrl())
                @php
                    $raw_width = null;
                    $width = null;
                    if (isset($class->model->settings)) {
                        $raw_width = property_exists($class->model->settings, 'raw_width') ? $class->model->settings->raw_width : null;
                        $width = property_exists($class->model->settings, 'width') ? $class->model->settings->width : null;
                    }
                @endphp
                @if ($raw_width == '25' || $width == 'w-full lg:w-1/4 lg:px-6')
                    <x-link href="{{ $report }}" class="lg:flex hidden text-purple hover:bg-gray-100 rounded-xl w-8 h-8 items-center justify-center text-sm text-right" override="class">
                        <x-tooltip id="tooltip-view-report" placement="top" message="{{ trans('widgets.view_report') }}" class="text-black left-5">
                            <x-icon icon="visibility" class="text-lg font-normal"></x-icon>
                        </x-tooltip>
                    </x-link>

                    <x-link href="{{ $report }}" class="lg:hidden text-purple text-sm text-right" override="class">
                        {{ trans('widgets.view_report') }}
                    </x-link>
                @else
                    <x-link href="{{ $report }}" class="text-purple text-sm mr-3 text-right" override="class">
                        <x-link.hover color="to-purple">
                            {{ trans('widgets.view_report') }}
                        </x-link.hover>
                    </x-link>
                @endif
            @endif
        </div>
    </div>

    <span class="h-6 block border-b text-black-400 text-xs truncate">
        {{ $class->getDescription() }}
    </span>
</div>
