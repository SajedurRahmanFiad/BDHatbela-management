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
                        <x-form.group.text name="steadfast_base_url" label="Base URL" value="{{ setting('courier.steadfast.base_url') }}" not-required />

                        <x-form.group.text name="steadfast_api_key" label="API Key" value="{{ setting('courier.steadfast.api_key') }}" not-required />

                        <x-form.group.text name="steadfast_secret_key" label="Secret Key" value="{{ setting('courier.steadfast.secret_key') }}" not-required />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="CarryBee" description="Configure CarryBee courier integration settings" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="carrybee_base_url" label="Base URL" value="{{ setting('courier.carrybee.base_url') }}" not-required />

                        <x-form.group.text name="carrybee_client_id" label="Client ID" value="{{ setting('courier.carrybee.client_id') }}" not-required />

                        <x-form.group.text name="carrybee_client_secret" label="Client Secret" value="{{ setting('courier.carrybee.client_secret') }}" not-required />

                        <x-form.group.text name="carrybee_client_context" label="Client Context" value="{{ setting('courier.carrybee.client_context') }}" not-required />

                        <x-form.group.text name="carrybee_store_id" label="Store ID" value="{{ setting('courier.carrybee.store_id') }}" not-required />
                    </x-slot>
                </x-form.section>

                @can('update-settings-courier')
                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons :cancel="url()->previous()" />
                    </x-slot>
                </x-form.section>
                @endcan

                <x-form.input.hidden name="_prefix" value="courier" />
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script folder="settings" file="settings" />
</x-layouts.admin>