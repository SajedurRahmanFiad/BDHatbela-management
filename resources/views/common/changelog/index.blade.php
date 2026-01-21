<x-layouts.admin>
    <x-slot name="title">{{ 'Changelog' }}</x-slot>

    <x-slot name="favorite"
        title="{{ 'Changelog' }}"
        icon="history"
        route="changelog.index"
    ></x-slot>

    <x-slot name="content">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h1 class="text-2xl font-semibold text-gray-900">{{ 'Changelog' }}</h1>
                    <p class="mt-1 text-sm text-gray-600">{{ 'Latest changes' }}</p>
                </div>

                <div class="p-6">
                    @if(empty($commits))
                        <div class="text-center py-8">
                            <span class="material-icons-outlined text-6xl text-gray-400">history</span>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">{{ 'No changes found' }}</h3>
                            <p class="mt-1 text-sm text-gray-500">{{ 'Unable to retrieve changelog' }}</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($commits as $commit)
                                <div class="flex items-start space-x-3 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-100">
                                            <span class="material-icons-outlined text-sm text-purple-600">commit</span>
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2">
                                            <code class="text-sm font-mono text-gray-500 bg-gray-200 px-2 py-1 rounded">{{ $commit['hash'] }}</code>
                                            <span class="text-sm text-gray-900">{{ $commit['message'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>
</x-layouts.admin>