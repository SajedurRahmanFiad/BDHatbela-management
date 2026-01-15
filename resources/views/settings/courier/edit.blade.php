<x-layouts.admin>
    <x-slot name="title">{{ trans('settings.courier.name') }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="setting" method="PATCH" route="settings.courier.update">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="Steadfast" description="Configure Steadfast courier integration settings" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="base_url" label="Base URL" value="{{ setting('courier.steadfast.base_url') }}" not-required />

                        <x-form.group.text name="api_key" label="API Key" value="{{ setting('courier.steadfast.api_key') }}" not-required />

                        <x-form.group.text name="secret_key" label="Secret Key" value="{{ setting('courier.steadfast.secret_key') }}" not-required />
                    </x-slot>
                </x-form.section>

                @can('update-settings-courier')
                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons :cancel="url()->previous()" />
                    </x-slot>
                </x-form.section>
                @endcan

                <x-form.input.hidden name="_prefix" value="courier.steadfast" />
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script folder="settings" file="settings" />
</x-layouts.admin>