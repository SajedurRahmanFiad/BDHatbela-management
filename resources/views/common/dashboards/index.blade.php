<x-layouts.admin>
    <x-slot name="title">{{ trans_choice('general.dashboards', 2) }}</x-slot>

    <x-slot name="content">
        <div class="py-12 text-center">
            <h2 class="text-xl font-bold mb-4">{{ trans_choice('general.dashboards', 2) }}</h2>
            <p class="mb-4">The multiple dashboard management feature has been removed. There is now a single fixed dashboard for the application where you can add and rearrange widgets.</p>
            <x-link href="{{ route('dashboard') }}" kind="primary">Go to Dashboard</x-link>
        </div>
    </x-slot>
</x-layouts.admin>
