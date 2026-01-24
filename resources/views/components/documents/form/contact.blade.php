<label for="contact" class="block text-sm font-medium text-gray-700 mb-2 flex justify-between items-center">
    <span>{{ $labelText }}</span>
    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="const el = this.closest('label').nextElementSibling; if (el && el.__vue__ && typeof el.__vue__.onContactCreate === 'function') { el.__vue__.onContactCreate(); }">
        + New
    </button>
</label>

<akaunting-contact-card
    placeholder="{{ $placeholder }}"
    no-data-text="{{ trans('general.no_data') }}"
    no-matching-data-text="{{ trans('general.no_matching_data') }}"
    search-route="{{ $searchRoute }}"
    create-route="{{ $createRoute }}"
    :contacts="{{ json_encode($dropdownContacts ?? $contacts) }}"
    :selected="{{ json_encode($selectedContact) }}"
    option-field="display_name"
    add-contact-text="{{ is_array($textAddContact) ? trans($textAddContact[0], ['field' => trans_choice($textAddContact[1], 1)]) : trans($textAddContact) }}"
    create-new-contact-text="{{ is_array($textCreateNewContact) ? trans($textCreateNewContact[0], ['field' => trans_choice($textCreateNewContact[1], 1)]) : trans($textCreateNewContact) }}"
    edit-contact-text="{{ is_array($textEditContact) ? trans($textEditContact[0], ['field' => trans_choice($textEditContact[1], 1)]) : trans($textEditContact) }}"
    contact-info-text="{{ is_array($textContactInfo) ? trans($textContactInfo[0], ['field' => trans_choice($textContactInfo[1], 1)]) : trans($textContactInfo) }}"
    tax-number-text="{{ trans('general.tax_number') }}"
    choose-different-contact-text="{{ is_array($textChooseDifferentContact) ? trans($textChooseDifferentContact[0], ['field' => Str::lower(trans_choice($textChooseDifferentContact[1], 1))]) : trans($textChooseDifferentContact) }}"
    :add-new="{{ json_encode([
        'status' => true,
        'text' => is_array($textCreateNewContact) ? trans($textCreateNewContact[0], ['field' => trans_choice($textCreateNewContact[1], 1)]) : trans($textCreateNewContact),
        'new_text' => trans('modules.new'),
        'buttons' => [
            'cancel' => [
                'text' => trans('general.cancel'),
                'class' => 'btn-outline-secondary'
            ],
            'confirm' => [
                'text' => trans('general.save'),
                'class' => 'disabled:bg-green-100'
            ]
        ]
    ])}}"
    :error="{{ $error }}"

    @change="onChangeContactCard"
></akaunting-contact-card>

@push('scripts_start')
<script>
function onChangeContactCard(contact) {
    // Use name field directly since display_name is used for dropdown display
    if (typeof this.form !== 'undefined') {
        this.form.contact_id = contact.id;
        this.form.contact_name = contact.name; // Use clean name field
        this.form.contact_email = contact.email || '';
        this.form.contact_has_email = !!contact.has_email;
        this.form.contact_tax_number = contact.tax_number || '';
        this.form.contact_phone = contact.phone || '';
        this.form.contact_address = contact.address || '';
        this.form.contact_country = contact.country || '';
        this.form.contact_state = contact.state || '';
        this.form.contact_zip_code = contact.zip_code || '';
    }
}
</script>
@endpush
