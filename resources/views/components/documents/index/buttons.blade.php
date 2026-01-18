@if ($checkPermissionCreate)
    @if ((auth()->check() && auth()->user()->isEmployee()) || auth()->user()->can($permissionCreate))
        @if (! $hideCreate)
            <x-link href="{{ route($createRoute) }}" kind="primary" id="index-more-actions-new-{{ $type }}">
                New Order
            </x-link>
        @endif
    @endif
@else
    @if (! $hideCreate)
        <x-link href="{{ route($createRoute) }}" kind="primary" id="index-more-actions-new-{{ $type }}">
            New Order
        </x-link>
    @endif
@endif
