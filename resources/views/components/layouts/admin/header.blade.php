@stack('header_start')

<div id="header" class="xl:pt-6 -mt-2">
    <div class="flex flex-col sm:flex-row items-start justify-between sm:space-x-4 hide-empty-page">
        <div data-page-title-first class="w-full sm:w-6/12 items-center mb-3 sm:mb-0">
            <div class="flex items-center space-y-4">


                <h1 class="flex items-center text-2xl xl:text-5xl text-black font-light -ml-0.5 mt-2 whitespace-nowrap mb-8">
                    <x-title>
                        {!! $title !!}
                    </x-title>
                    {!! $favorite ?? '' !!}
                    @yield('dashboard_action')

                    @if (! empty($status))
                        <span class="ml-4 flex items-center align-middle">
                            {!! $status !!}
                        </span>
                    @endif
                </h1>

                {!! $info ?? '' !!}

                {{-- Favorite button moved inside h1 for alignment --}}
            </div>
        </div>

        <div data-page-title-second class="w-full flex flex-wrap flex-col sm:flex-row sm:items-center justify-end sm:space-x-2 sm:rtl:space-x-reverse suggestion-buttons">
            @stack('header_button_start')

            {!! $buttons !!}

            @stack('header_button_end')

            @stack('header_suggestion_start')

            <x-suggestions />

            @stack('header_suggestion_end')

            {!! $moreButtons !!}
        </div>
    </div>
</div>

@stack('header_end')
