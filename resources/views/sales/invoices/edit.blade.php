<x-layouts.admin>
    <x-slot name="title">
        {{ trans('general.title.edit', ['type' => trans_choice('general.invoices', 1)]) }}
    </x-slot>

    <x-slot name="content">
        <x-documents.form.content type="invoice" :document="$invoice" hide-due-at hide-order-number />
    </x-slot>

    <x-documents.script type="invoice" :items="$invoice->items()->get()" :document="$invoice" />
</x-layouts.admin>
