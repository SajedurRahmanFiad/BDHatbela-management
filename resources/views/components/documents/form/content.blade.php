@props(['hideDueAt' => false, 'hideOrderNumber' => false])

<x-loading.content />

<div class="relative mt-4">
    <x-form 
        id="{{ $formId }}"
        :route="$formRoute"
        method="{{ $formMethod }}"
        :model="$document"
    >
        @if (! $hideCompany)
            <x-documents.form.company :type="$type" />
        @else
            {{-- When the company selector is hidden, include the current company id as a hidden field so the document has a company_id on create --}}
            <x-form.input.hidden name="company_id" :value="company_id()" />
        @endif

        <x-documents.form.main type="{{ $type }}" />

        @if ($showRecurring)
            <x-documents.form.recurring type="{{ $type }}" />
        @endif

        @if (! $hideAdvanced)
            <div style="display:none">
                <x-documents.form.advanced type="{{ $type }}" />
            </div>
        @endif

        <x-form.input.hidden name="type" :value="old('type', $type)" v-model="form.type" />
        <x-form.input.hidden name="status" :value="old('status', $status)" v-model="form.status" />
        <x-form.input.hidden name="amount" :value="old('amount', '0')" v-model="form.amount" />

        @if (! $hideButtons)
            <x-documents.form.buttons :type="$type" />
        @endif
    </x-form>
</div>
