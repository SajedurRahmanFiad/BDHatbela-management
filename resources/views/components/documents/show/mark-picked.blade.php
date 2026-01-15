    @php
        $pickedHistory = $document->histories->where('status', 'picked')->first();
        $description = $pickedHistory ? 'Order marked as Picked on ' . company_date($pickedHistory->created_at) . ' at ' . $pickedHistory->created_at->format('h:i A') : '';
    @endphp
@if (in_array($type, ['invoice', 'invoice-recurring']) && $document->status != 'draft')
<x-show.accordion type="mark_picked" :open="isset($accordionActive) && ($accordionActive == 'mark-picked')">
    <x-slot name="head">
        <x-show.accordion.head
            title="{{ trans('documents.statuses.picked') }}"
            description="{{ $description }}"
        />
    </x-slot>

    <x-slot name="body">
        @stack('timeline_mark_picked_body_start')

        <div class="flex flex-wrap space-x-3 rtl:space-x-reverse">

            @stack('timeline_mark_picked_body_button_start')

            {{-- Allow picking only when the order is in a "processing" state.
                 For invoices this corresponds to sent/viewed/partial. --}}
            @if (in_array($document->status, ['sent', 'viewed', 'partial']))
                @if (! (user() && user()->isEmployee()))
                    @can(isset($permissionUpdate) ? $permissionUpdate : 'update-sales-invoices')
                        <x-link id="show-slider-actions-mark-picked-{{ $document->type }}" href="{{ route(isset($markPickedRoute) ? $markPickedRoute : 'invoices.picked', $document->id) }}" @click="e => e.target.classList.add('disabled')">
                            <x-link.loading>
                                {{ trans('documents.actions.mark_picked') ?? 'Picked by courier' }}
                            </x-link.loading>
                        </x-link>
                    @endcan
                @endif
            @endif

            @stack('timeline_mark_picked_body_button_end')

        </div>

        @stack('timeline_mark_picked_body_end')
    </x-slot>
</x-show.accordion>
@endif
