@props(['id', 'name', 'href', 'active', 'type', 'tab'])

@if (empty($href))
    <x-tabs.nav :id="$id" :active="$active ?? false">
        {{ $name }}
    </x-tabs.nav>
@else
    <x-tabs.nav-link :id="$id" :href="$href" :active="$active ?? false">
        {{ $name }}
    </x-tabs.nav-link>
@endif
