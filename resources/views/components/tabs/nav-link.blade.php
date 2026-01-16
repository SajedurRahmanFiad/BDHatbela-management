@props(['id', 'href', 'active'])

<li 
    class="relative flex-auto px-4 text-sm text-center pb-2 cursor-pointer transition-all border-b whitespace-nowrap tabs-link"
    id="tab-{{ $id }}"
    {{ $attributes }}
>
    <a href="{{ $href }}" class="block">
        @if ($slot->isNotEmpty())
            {!! $slot !!}
        @else
            {{ $name ?? '' }}
        @endif
    </a>
</li>
