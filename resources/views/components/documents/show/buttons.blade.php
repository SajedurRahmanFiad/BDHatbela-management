@stack('add_new_button_start')

@if (! $hideCreate)
    @can($permissionCreate)
        <x-link href="{{ route($createRoute) }}" kind="primary" id="show-more-actions-new-{{ $document->type }}">
            {{ trans('general.title.new', ['type' => trans_choice($textPage, 1)]) }}
        </x-link>
    @endcan
@endif

@stack('edit_button_start')

@if (! in_array($document->status, $hideButtonStatuses))
    @if (user() && user()->isEmployee() && ($document->created_by != user()->id || $document->status != 'draft'))
        {{-- Hide edit for employees if not their own draft --}}
    @else
        @if (! $hideEdit)
            @if ((auth()->check() && auth()->user()->isEmployee() && $document->created_by == auth()->user()->id && $document->status == 'draft') || auth()->user()->can($permissionUpdate))
                <x-link href="{{ route($editRoute, $document->id) }}" id="show-more-actions-edit-{{ $document->type }}">
                    {{ trans('general.edit') }}
                </x-link>
            @endif
        @endif
    @endif
@endif

@stack('edit_button_end')
