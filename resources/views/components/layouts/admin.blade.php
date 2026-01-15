<!DOCTYPE html>
<html dir="{{ language()->direction() }}" lang="{{ app()->getLocale() }}">
    <x-layouts.admin.head>
        @if (! empty($metaTitle))
        <x-slot name="metaTitle">
            {!! !empty($metaTitle->attributes->has('title')) ? $metaTitle->attributes->get('title') : $metaTitle !!}
        </x-slot>
        @endif

        <x-slot name="title">
            {!! !empty($title->attributes->has('title')) ? $title->attributes->get('title') : $title !!}
        </x-slot>
        
        @push('css')
        <style>
            #menu-apps-home {
                display: none !important;
            }
            
            .ltr\:pl-12 {
                display: none !important;
            }
            
            a[id^="suggestion-"] {
                display: none !important;
            }
            
            #index-more-actions-new-company {
                display: none !important;
            }
            
            .bg-orange-50.p-4.my-4 {
                display: none !important;
            }

            .relative.w-full.my-8 {
                display: none !important;
            }
            
            li:has(a[href*="utm_campaign=bank_feeds"]),
            li:has(a[href*="salesperson"]),
            li:has(a[href*="payroll"]),
            li:has(a[href*="receipt"]),
            li:has(a[href*="credit-debit-notes"]),
            li:has(a[href*="sales-purchase-orders"]) {
                display: none !important;
            }

            .relative:has(> #city), 
            .relative:has(> div > #city) {
                display: none !important;
            }

            div.mb-14:has(#person-button-add) {
                display: none !important;
            }

            #form-select-country {
                display: none !important;
            }

            li:has(#menu-settings-taxes) {
                display: none !important;
            }

            li:has(#menu-paypal-standard-settings) {
                display: none !important;
            }

            li:has(#menu-settings-currencies) {
                display: none !important;
            }

            li:has(#menu-settings-schedule) {
                display: none !important;
            }

            /* Hide any remaining links or elements that point to the apps pages */
            a[href*="/apps"],
            a[href*="apps/"],
            a[href*="akaunting.com/apps"],
            li:has(a[href*="/apps"]),
            img[src*="no-apps.png"] {
                display: none !important;
            }
            
        </style>
        @endpush
        
    </x-layouts.admin.head>

    @mobile
    <body class="bg-body">
    @elsemobile
    <body class="bg-body overflow-y-overlay">
    @endmobile

        @stack('body_start')

        <x-layouts.admin.menu />

        <!-- loading component will add this line -->

        <div class="main-content xl:ltr:ml-64 xl:rtl:mr-64 transition-all ease-in-out" id="panel">
            <div id="main-body">
                <div class="container">
                    <x-layouts.admin.header>
                        <x-slot name="title">
                            {!! ! empty($title->attributes->has('title')) ? $title->attributes->get('title') : $title !!}
                        </x-slot>

                        @if (! empty($status))
                            <x-slot name="status">
                                {!! $status !!}
                            </x-slot>
                        @endif

                        @if (! empty($info))
                            <x-slot name="info">
                                {!! $info !!}
                            </x-slot>
                        @endif

                        @if (! empty($favorite) || (! empty($favorite) && $favorite->attributes->has('title')))
                            @if (! $favorite->attributes->has('title'))
                                <x-slot name="favorite">
                                    {!! $favorite !!}
                                </x-slot>
                            @else
                                @php
                                    $favorite = [
                                        'title' => $favorite->attributes->get('title'),
                                        'icon' => $favorite->attributes->get('icon'),
                                        'route' => !empty($favorite->attributes->has('route')) ? $favorite->attributes->get('route') : '',
                                        'url' => !empty($favorite->attributes->has('url')) ? $favorite->attributes->get('url') : '',
                                    ];
                                @endphp

                                <x-slot name="favorite">
                                    <x-menu.favorite
                                        :title="$favorite['title']"
                                        :icon="$favorite['icon']"
                                        :route="$favorite['route']"
                                        :url="$favorite['url']"
                                    />
                                </x-slot>
                            @endif
                        @endif

                        <x-slot name="buttons">
                            {!! $buttons ?? '' !!}
                        </x-slot>

                        <x-slot name="moreButtons">
                            {!! $moreButtons ?? '' !!}
                        </x-slot>
                    </x-layouts.admin.header>

                    <x-layouts.admin.content>
                        <livewire:notification.browser />

                        <x-layouts.admin.notifications />

                        {!! $content !!}
                    </x-layouts.admin.content>

                    <x-layouts.admin.footer />
                </div>
            </div>
        </div>

        @stack('body_end')

        <x-layouts.admin.scripts />
    </body>
</html>
