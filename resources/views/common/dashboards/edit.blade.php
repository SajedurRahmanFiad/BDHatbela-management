<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.edit', ['type' => trans_choice('general.dashboards', 1)]) }}</x-slot>

    <x-slot name="content">
        <div class="py-12 text-center">
            <h2 class="text-xl font-bold mb-4">{{ trans('general.title.edit', ['type' => trans_choice('general.dashboards', 1)]) }}</h2>
            <p class="mb-4">Editing dashboards has been disabled. The application uses a single fixed dashboard for widgets.</p>
            <x-link href="{{ route('dashboard') }}" kind="primary">Go to Dashboard</x-link>
        </div>
    </x-slot>
</x-layouts.admin>
