@if ($hideEmptyPage)
    @if (! $hideSummary)
    <x-index.summary :items="$summaryItems" />
    @endif

    <x-index.container>
        @if (! $withoutTabs)
            @php
                $real_type = str_replace('-recurring', '', $type);
            @endphp

            <x-tabs active="{{ $tabActive }}" id="tabs-{{ $real_type }}">
                <x-slot name="navs">
                    @stack('document_nav_start')


                    {{-- All Orders tab first --}}
                    @if ($tabActive == $real_type . '-all')
                        <x-tabs.nav
                            id="{{ $real_type . '-all' }}"
                            :active="$tabActive == $real_type . '-all'"
                        >
                            {{ trans('general.all_type', ['type' => ($real_type === 'bill' || $real_type === 'bills') ? trans_choice('general.bills', 2) : trans_choice('dynamic.invoices', 2)]) }}
                        </x-tabs.nav>
                    @else
                        <x-tabs.nav-pin
                            id="{{ $real_type . '-all' }}"
                            href="{{ route($routeTabDocument, $routeParamsTabAll) }}"
                            name="{{ trans('general.all_type', ['type' => ($real_type === 'bill' || $real_type === 'bills') ? trans_choice('general.bills', 2) : trans_choice('dynamic.invoices', 2)]) }}"
                            type="{{ $real_type }}"
                            tab="all"
                        />
                    @endif

                    @if ($tabActive == $real_type . '-draft')
                        <x-tabs.nav
                            id="{{ $real_type . '-draft' }}"
                            :active="$tabActive == $real_type . '-draft'"
                        >
                            {{ trans('documents.statuses.draft') }}
                        </x-tabs.nav>
                    @else
                        <x-tabs.nav-pin
                            id="{{ $real_type . '-draft' }}"
                            href="{{ route($routeTabDocument, $routeParamsTabDraft) }}"
                            name="{{ trans('documents.statuses.draft') }}"
                            type="{{ $real_type }}"
                            tab="draft"
                        />
                    @endif

                    @if ($tabActive == $real_type . '-unpaid')
                        <x-tabs.nav
                            id="{{ $real_type . '-unpaid' }}"
                            :active="$tabActive == $real_type . '-unpaid'"
                        >
                            {{ ($real_type === 'bill' || $real_type === 'bills') ? trans('documents.statuses.received') : trans('documents.statuses.sent') }}
                        </x-tabs.nav>
                    @else
                        <x-tabs.nav-pin
                            id="{{ $real_type . '-unpaid' }}"
                            href="{{ route($routeTabDocument, $routeParamsTabUnpaid) }}"
                            name="{{ ($real_type === 'bill' || $real_type === 'bills') ? trans('documents.statuses.received') : trans('documents.statuses.sent') }}"
                            type="{{ $real_type }}"
                            tab="unpaid"
                        />
                    @endif

                    {{-- Picked tab --}}
                    @if ($real_type === 'invoices' || $real_type === 'invoice')
                        @if ($tabActive == $real_type . '-picked')
                            <x-tabs.nav
                                id="{{ $real_type . '-picked' }}"
                                :active="$tabActive == $real_type . '-picked'"
                            >
                                {{ trans('documents.statuses.picked') }}
                            </x-tabs.nav>
                        @else
                            <x-tabs.nav-pin
                                id="{{ $real_type . '-picked' }}"
                                href="{{ route($routeTabDocument, $routeParamsTabPicked) }}"
                                name="{{ trans('documents.statuses.picked') }}"
                                type="{{ $real_type }}"
                                tab="picked"
                            />
                        @endif
                    @endif

                    {{-- Completed tab --}}
                    @if ($tabActive == $real_type . '-completed')
                        <x-tabs.nav
                            id="{{ $real_type . '-completed' }}"
                            :active="$tabActive == $real_type . '-completed'"
                        >
                            {{ trans('documents.statuses.paid') }}
                        </x-tabs.nav>
                    @else
                        <x-tabs.nav-pin
                            id="{{ $real_type . '-completed' }}"
                            href="{{ route($routeTabDocument, $routeParamsTabCompleted) }}"
                            name="{{ trans('documents.statuses.paid') }}"
                            type="{{ $real_type }}"
                            tab="completed"
                        />
                    @endif

                    {{-- Cancelled tab --}}
                    @if ($real_type === 'invoices' || $real_type === 'invoice')
                        @if ($tabActive == $real_type . '-cancelled')
                            <x-tabs.nav
                                id="{{ $real_type . '-cancelled' }}"
                                :active="$tabActive == $real_type . '-cancelled'"
                            >
                                {{ trans('documents.statuses.cancelled') }}
                            </x-tabs.nav>
                        @else
                            <x-tabs.nav-pin
                                id="{{ $real_type . '-cancelled' }}"
                                href="{{ route($routeTabDocument, $routeParamsTabCancelled) }}"
                                name="{{ trans('documents.statuses.cancelled') }}"
                                type="{{ $real_type }}"
                                tab="cancelled"
                            />
                        @endif
                    @endif

                    @stack('document_nav_end')

                    {{-- Recurring Templates tab removed --}}
                </x-slot>

                <x-slot name="content">
                    @if ((! $hideSearchString) && (! $hideBulkAction))
                    <x-index.search
                        search-string="{{ $searchStringModel }}"
                        bulk-action="{{ $bulkActionClass }}"
                        route="{{ $searchRoute }}"
                    />
                    @elseif ((! $hideSearchString) && $hideBulkAction)
                    <x-index.search
                        search-string="{{ $searchStringModel }}"
                        route="{{ $searchRoute }}"
                    />
                    @elseif ($hideSearchString && (! $hideBulkAction))
                    <x-index.search
                        bulk-action="{{ $bulkActionClass }}"
                        route="{{ $searchRoute }}"
                    />
                    @endif

                    @stack('document_tab_start')

                    @if ($tabActive != 'recurring-templates')
                        <x-tabs.tab id="{{ $tabActive }}">
                            <x-documents.index.document :type="$type" :documents="$documents" />
                        </x-tabs.tab>
                    @endif

                    @stack('document_tab_end')

                    @if ($tabActive == 'recurring-templates')
                        @if (! $hideRecurringTemplates)
                        <x-tabs.tab id="recurring-templates">
                            <x-documents.index.recurring-templates :type="$type" :documents="$documents" />
                        </x-tabs.tab>
                        @endif
                    @endif

                    @stack('recurring_tab_end')
                </x-slot>
            </x-tabs>
        @else
            @if ((! $hideSearchString) && (! $hideBulkAction))
            <x-index.search
                search-string="{{ $searchStringModel }}"
                bulk-action="{{ $bulkActionClass }}"
                route="{{ $searchRoute }}"
            />
            @elseif ((! $hideSearchString) && $hideBulkAction)
            <x-index.search
                search-string="{{ $searchStringModel }}"
                route="{{ $searchRoute }}"
            />
            @elseif ($hideSearchString && (! $hideBulkAction))
            <x-index.search
                bulk-action="{{ $bulkActionClass }}"
                route="{{ $searchRoute }}"
            />
            @endif

            @stack('document_start')

            <x-documents.index.document :type="$type" :documents="$documents" />

            @stack('document_end')
        @endif
    </x-index.container>
@else
    <x-empty-page
        group="{{ $group }}"
        page="{{ $page }}"
        alias="{{ $alias }}"
        :buttons="$emptyPageButtons"
        image-empty-page="{{ $imageEmptyPage }}"
        text-empty-page="{{ $textEmptyPage }}"
        url-docs-path="{{ $urlDocsPath }}"
        check-permission-create="{{ $checkPermissionCreate }}"
    />
@endif
