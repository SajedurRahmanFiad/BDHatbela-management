@props(['companies'])

<x-loading.menu />

<div class="container flex items-center py-3 mb-4 border-b-2 xl:hidden">
    <span class="material-icons text-black js-hamburger-menu">menu</span>

    <div class="flex items-center m-auto">
        <img src="{{ asset('public/img/akaunting-logo-green.svg') }}" class="w-8 m-auto" alt="Akaunting" />
        <span class="ltr:ml-2 rtl:mr-2">{{ Str::limit(setting('company.name'), 22) }}</span>
    </div>

    @if(request()->route()->getName() == 'customers.index')
        <x-contacts.index.more-buttons type="customer" />
    @elseif(request()->route()->getName() == 'vendors.index')
        <x-contacts.index.more-buttons type="vendor" />
    @elseif(request()->route()->getName() == 'invoices.index')
        <x-documents.index.more-buttons type="invoice" />
    @elseif(request()->route()->getName() == 'bills.index')
        <x-documents.index.more-buttons type="bill" />
    @elseif(request()->route()->getName() == 'recurring-invoices.index')
        <x-documents.index.more-buttons type="invoice-recurring" />
    @elseif(request()->route()->getName() == 'recurring-bills.index')
        <x-documents.index.more-buttons type="bill-recurring" />
    @endif
</div>

@stack('menu_start')

<div
    x-data="{ }"
    x-init="() => {
        const loadEvent = 'onpagehide' in window ? 'pageshow' : 'load';
        window.addEventListener(loadEvent, () => {
            $refs.realMenu.classList.remove('hidden');
        });
    }"
    x-ref="realMenu"
    class="w-70 h-screen flex hidden fixed top-0 js-menu z-20 xl:z-10 transition-all ltr:-left-80 rtl:-right-80 xl:ltr:left-0 xl:rtl:right-0"
>
    <div class="w-14 py-7 px-1 bg-lilac-900 z-10 menu-scroll overflow-y-auto overflow-x-hidden">

        <div class="group flex flex-col items-center justify-center menu-toggle-buttons">
            <x-tooltip id="tooltip-new" placement="right" message="{{ trans('general.new') }}">
                <button type="button" class="add-item menu-button flex items-center justify-center w-16 h-16 mb-5 cursor-pointer js-menu-toggles" data-menu="add-new-menu">
                    <span id="menu-neww-icon" name="add_circle_outline" class="material-icons-outlined text-purple text-5xl pointer-events-none">add_circle_outline</span>
                </button>
            </x-tooltip>

            @can('read-notifications')
                <x-tooltip id="tooltip-notifications" placement="right" message="{{ trans_choice('general.your_notifications', 2) }}">
                    <button type="button" class="notifications-item menu-button flex items-center justify-center w-8 h-8 mb-2.5 cursor-pointer js-menu-toggles relative" data-menu="notifications-menu">
                        <span name="notifications" class="material-icons-outlined text-purple text-2xl pointer-events-none">notifications</span>
                        @php $unread = user() ? user()->unreadNotifications->count() : 0; @endphp
                        <span data-notification-count class="absolute -top-0 -right-0 bg-red-500 text-white rounded-full text-xs px-1" style="{{ $unread > 0 ? '' : 'display:none' }}">{{ $unread }}</span>
                    </button>
                </x-tooltip>
            @endcan

            <div
                data-tooltip-target="tooltip-profile"
                data-tooltip-placement="right"
                class="flex flex-col items-center justify-center cursor-pointer menu-button"
                data-menu="profile-menu"
            >
                <span id="menu-profile-icon-cancel" name="account_circle" class="material-icons-outlined w-8 h-8 flex items-center justify-center text-purple text-2xl hidden pointer-events-none">
                    account_circle
                </span>

                @if (setting('default.use_gravatar', '0') == '1')
                    <img src="{{ user()->picture }}" alt="{{ user()->name }}" class="w-8 h-8 m-auto rounded-full text-transparent" alt="{{ user()->name }}" title="{{ user()->name }}">
                @elseif (is_object(user()->picture))
                    <img src="{{ Storage::url(user()->picture->id) }}" class="w-8 h-8 m-auto rounded-full text-transparent" alt="{{ user()->name }}" title="{{ user()->name }}">
                @else
                    <span id="menu-profile-icon" name="account_circle" class="material-icons-outlined text-purple w-8 h-8 flex items-center justify-center text-center text-2xl pointer-events-none" alt="{{ user()->name }}" title="{{ user()->name }}">
                        account_circle
                    </span>
                @endif
            </div>

            <div id="tooltip-profile" class="inline-block absolute z-20 py-1 px-2 text-sm font-medium rounded-lg bg-white text-gray-900 w-auto border border-gray-200 shadow-sm whitespace-nowrap opacity-0 invisible">
                {{ trans('auth.profile') }}
                <div class="absolute w-2 h-2 before:absolute before:w-2 before:h-2 before:bg-white before:border-gray-200 before:transform before:rotate-45 before:border -left-1 before:border-t-0 before:border-r-0 border-gray-200" data-popper-arrow></div>
            </div>

            @if (! user()->isEmployee())
                <x-tooltip id="tooltip-settings" placement="right" message="{{ trans_choice('general.settings', 2) }}">
                    <button type="button" class="settings-item menu-button flex items-center justify-center w-8 h-8 mb-2.5 cursor-pointer js-menu-toggles" data-menu="settings-menu">
                        <span id="menu-settings-icon" name="settings" class="material-icons-outlined text-purple text-2xl pointer-events-none">settings</span>
                    </button>
                </x-tooltip>
            @endif
        </div>

        <livewire:menu.favorites />
    </div>

    @stack('main_menu_start')

    <nav class="menu-list js-main-menu" id="sidenav-main">
        @stack('main_menu_company_start')

        <div class="relative mb-5">
            <div class="flex items-center">
                <div class="w-8 h-8 flex items-center justify-center">
                    <img src="{{ asset('public/img/akaunting-logo-green.svg') }}" class="w-6 h-6" alt="Akaunting" />
                </div>

                <div class="flex ltr:ml-2 rtl:mr-2">
                    <span class="w-28 ltr:text-left rtl:text-right block text-base truncate">
                        <x-button.hover>
                            {{ Str::limit(setting('company.name'), 22) }}
                        </x-button.hover>
                    </span>
                </div>
            </div>
        </div>

        @stack('main_menu_admin_start')

        <div class="main-menu transform">
            {!! menu('admin') !!}
        </div>

        @stack('main_menu_admin_end')
    </nav>

    @stack('main_menu_end')

    @stack('profile_menu_start')

    <div class="profile-menu user-menu menu-list fixed h-full ltr:-left-80 rtl:-right-80">
        @stack('profile_menu_avatar_start')

        <div class="flex h-12.5">
            @if (setting('default.use_gravatar', '0') == '1')
                <img src="{{ user()->picture }}" alt="{{ user()->name }}" class="w-8 h-8 rounded-full" alt="{{ user()->name }}" title="{{ user()->name }}">
            @elseif (is_object(user()->picture))
                <img src="{{ Storage::url(user()->picture->id) }}" class="w-8 h-8 rounded-full" alt="{{ user()->name }}" title="{{ user()->name }}">
            @else
                <span name="account_circle" class="material-icons-outlined w-8 h-8 flex items-center justify-center text-purple text-2xl pointer-events-none" alt="{{ user()->name }}" title="{{ user()->name }}">account_circle</span>
            @endif

            @stack('navbar_profile_welcome')

            <div class="flex flex-col text-black ml-2">
                <span class="text-xs">{{ trans('general.welcome') }}</span>

                {{ user()->name }}
            </div>
        </div>

        @stack('profile_menu_profile_start')

        <livewire:menu.profile />

        @stack('profile_menu_profile_end')
    </div>

    @stack('profile_menu_end')

    @can('read-notifications')
    @stack('notifications_menu_start')

    <div class="notifications-menu user-menu menu-list fixed h-full ltr:-left-80 rtl:-right-80">
        @stack('notifications_menu_title_start')

        <div class="flex items-center mb-3">
            <span name="notifications" class="material-icons-outlined w-8 h-8 flex items-center justify-center text-purple text-2xl pointer-events-none">notifications</span>

            <div class="text-black ltr:ml-1 rtl:mr-1">
                {{ trans_choice('general.your_notifications', 2) }}
            </div>
        </div>

        @stack('notifications_menu_notifications_start')

        <livewire:menu.notifications />

        @stack('notifications_menu_notifications_end')
    </div>

    @stack('notifications_menu_end')
    @endcan

    @stack('settings_menu_start')

    <div class="settings-menu user-menu menu-list fixed h-full overflow-y-unset ltr:-left-80 rtl:-right-80">
        @stack('settings_menu_title_start')

        <div class="flex items-center mb-3">
            <span name="settings" class="material-icons-outlined w-8 h-8 flex items-center justify-center text-purple text-2xl pointer-events-none">settings</span>

            <div class="text-black ltr:ml-1 rtl:mr-1">
                {{ trans_choice('general.settings', 2) }}
            </div>
        </div>

        @stack('settings_menu_settings_start')

        <livewire:menu.settings />

        @stack('settings_menu_settings_end')
    </div>

    @stack('settings_menu_end')

    @stack('add_new_menu_start')

    <div class="add-new-menu user-menu menu-list fixed h-full ltr:-left-80 rtl:-right-80">
        @stack('add_new_menu_title_start')

        <div class="flex items-center mb-3">
            <span name="add_circle_outline" class="material-icons-outlined w-8 h-8 flex items-center justify-center text-purple text-2xl pointer-events-none">add_circle_outline</span>

            <div class="text-black ltr:ml-1 rtl:mr-1">
                {{ trans('general.new_more') }}
            </div>
        </div>

        @stack('add_new_menu_add_new_start')

        <livewire:menu.neww />

        @stack('add_new_menu_add_new_end')
    </div>

    @stack('add_new_menu_end')

    <button type="button" class="toggle-button absolute ltr:-right-2 rtl:-left-2 top-8 cursor-pointer transition-opacity ease-in-out z-50">
        <span class="material-icons text-lg text-purple transform ltr:rotate-90 rtl:-rotate-90 pointer-events-none">expand_circle_down</span>
    </button>

    <span data-menu-close id="menu-cancel" class="material-icons absolute ltr:-right-2 rtl:-left-1.5 transition-all top-8 text-lg text-purple cursor-pointer z-10 hidden">cancel</span>

    <div class="fixed w-full h-full invisible lg:hidden js-menu-background" style="background-color: rgba(0, 0, 0, 0.5); z-index: -1;"></div>
</div>

@stack('menu_end')
