<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans_choice('general.customers', 1)]) }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ trans('general.title.new', ['type' => trans_choice('general.customers', 1)]) }}"
        icon="person"
        route="customers.create"
    ></x-slot>

    <x-slot name="content">
        <x-contacts.form.content type="customer" hide-logo hide-email hide-website hide-reference hide-tax-number hide-state hide-currency hide-zip-code hide-can-login hide-section-billing />
    </x-slot>

    <x-contacts.script type="customer" />
</x-layouts.admin>
