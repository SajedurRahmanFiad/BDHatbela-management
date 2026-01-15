<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => 'border-b-0'])

    <div class="my-3 text-black-400 text-sm">
        {{ $grand_total_text }}: <span class="font-bold">{{ $totals['grand'] }}</span>
    </div>

    <div class="my-3" aria-hidden="true">
        <div @class(['h-3', 'rounded-md', 'bg-red-300' => $has_progress, 'bg-gray-300' => ! $has_progress])>
            <div @class(['h-3', 'rounded-md', 'bg-orange-300' => $has_progress, 'bg-gray-300' => ! $has_progress]) style="width: {{ $progress }}%;"></div>
        </div>
    </div>

</div>
