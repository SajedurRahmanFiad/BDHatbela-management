<x-layouts.admin>
    <x-slot name="title">
        {{ setting('invoice.title', trans_choice('general.invoices', 1)) . ': ' . $invoice->document_number }}
    </x-slot>

    <x-slot name="status">
        <div class="flex items-center">
            <x-show.status status="{{ $invoice->status }}" background-color="bg-{{ $invoice->status_label }}" text-color="text-text-{{ $invoice->status_label }}" />
            @if ($invoice->histories->where('status', 'steadfast_sent')->first() && !in_array($invoice->status, ['paid', 'picked', 'cancelled']))
                <img src="{{ asset('public/img/steadfast.png') }}" alt="Steadfast" title="Added to Steadfast" class="w-5 h-5 ml-2" />
            @endif
            @if ($invoice->histories->where('status', 'carrybee_sent')->first() && !in_array($invoice->status, ['paid', 'picked', 'cancelled']))
                <img src="{{ asset('public/img/carrybee.png') }}" alt="CarryBee" title="Added to CarryBee" class="w-5 h-5 ml-2" />
            @endif
        </div>
    </x-slot>

    <x-slot name="buttons">
        <x-documents.show.buttons type="invoice" :document="$invoice" />
    </x-slot>

    <x-slot name="moreButtons">
        <x-documents.show.more-buttons type="invoice" :document="$invoice" :hide-customize="true" />
    </x-slot>

    <x-slot name="content">
        <x-documents.show.content type="invoice" :document="$invoice" hide-receive hide-make-payment hide-schedule hide-children />
    </x-slot>

    @push('stylesheet')
        <link rel="stylesheet" href="{{ asset('public/css/print.css?v=' . version('short')) }}" type="text/css">
    @endpush

    <x-documents.script type="invoice" :document="$invoice" />
</x-layouts.admin>
