<x-show.accordion type="create" :open="($accordionActive == 'create')">
    <x-slot name="head">
        <x-show.accordion.head
            title="{{ trans('general.create') }}"
            description="{!! trans($description, [
                'user' => $user_name,
                'type' => $type_lowercase,
                'date' => $created_date,
            ]) !!}"
        />
    </x-slot>

    <x-slot name="body">
        @stack('timeline_create_body_start')

        <div class="flex">
            @stack('timeline_create_body_button_edit_start')

            @if (! $hideEdit)
                @if ((auth()->check() && auth()->user()->isEmployee() && $document->created_by == auth()->user()->id && $document->status == 'draft') || auth()->user()->can($permissionUpdate))
                    @if ($document->status != 'cancelled')
                        <x-link href="{{ route($editRoute, $document->id) }}" id="show-slider-actions-edit-{{ $document->type }}" @click="e => e.target.classList.add('disabled')">
                            {{ trans('general.edit') }}
                        </x-link>
                    @else
                        <x-button kind="disabled" disabled="disabled">
                            {{ trans('general.edit') }}
                        </x-button>
                    @endif
                @endif
            @endif

            @stack('timeline_create_body_button_edit_end')
        </div>

        @stack('timeline_create_body_end')
    </x-slot>
</x-show.accordion>
