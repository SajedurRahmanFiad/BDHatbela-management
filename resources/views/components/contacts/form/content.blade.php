<x-form.container>
    <x-form
        id="{{ $formId }}"
        :route="$formRoute"
        method="{{ $formMethod }}"
        :model="$contact"
    >
        @if (! $hideSectionGeneral)
            <x-contacts.form.general type="{{ $type }}" />
        @endif

        @if (! $hideSectionBilling)
            <x-contacts.form.billing type="{{ $type }}" />
        @endif

        @if (! $hideSectionAddress)
            <x-contacts.form.address type="{{ $type }}" />
        @endif

        @if (! $hideSectionPersons)
            <x-contacts.form.persons type="{{ $type }}" />
        @endif

        <x-form.input.hidden name="type" value="{{ $type }}" />

        @if ($hideSectionBilling || $hideCurrency)
            <x-form.input.hidden name="currency_code" value="{{ old('currency_code', ! empty($contact) && $contact->currency_code ? $contact->currency_code : default_currency()) }}" />
        @endif

        @if ($hideCanLogin)
            <x-form.input.hidden name="create_user" value="0" />
        @endif

        @if (! empty($contact))
            <x-form.group.switch name="enabled" label="{{ trans('general.enabled') }}" />
        @endif

        <x-contacts.form.buttons type="{{ $type }}" />
    </x-form>
</x-form.container>
