<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.new', ['type' => trans_choice('general.vendors', 1)]) }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ trans('general.title.new', ['type' => trans_choice('general.vendors', 1)]) }}"
        icon="engineering"
        route="vendors.create"
    ></x-slot>

    <x-slot name="content">
        <x-contacts.form.content type="vendor" hide-can-login hide-email hide-website hide-reference hide-section-billing hide-zip-code hide-state />
    </x-slot>

    <x-contacts.script type="vendor" />
</x-layouts.admin>
