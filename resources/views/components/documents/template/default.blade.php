<div class="print-template">
    @php
        $bengaliFontPath = storage_path('fonts/NotoSansBengali-Regular.ttf');
    @endphp

    @if (file_exists($bengaliFontPath))
        @php
            $fontUrl = '';

            // When generating PDF server-side, allow dompdf to load the font via file:// path.
            // For browser previews, embed the font as a data URI so the browser can load it without using file:// which is blocked.
            if (! empty($pdf) && $pdf) {
                $fontUrl = 'file://' . $bengaliFontPath;
            } else {
                try {
                    $fontData = base64_encode(file_get_contents($bengaliFontPath));
                    $fontUrl = 'data:font/truetype;charset=utf-8;base64,' . $fontData;
                } catch (\Exception $e) {
                    $fontUrl = '';
                }
            }
        @endphp

        <style>
            @font-face {
                font-family: 'Noto Sans Bengali';
                src: url('{{ $fontUrl }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            /* Apply to PDF output to ensure BDT glyph renders */
            /* Use DejaVu Sans first so Latin characters render correctly; fall back to Noto Sans Bengali for Bengali glyphs */
            .print-template, .print-template * {
                font-family: 'DejaVu Sans', 'Noto Sans Bengali', sans-serif !important;
            }

            .print-template p,
            .print-template td,
            .print-template text,
            .print-template .text,
            .print-template .text *,
            .line-item-row {
                font-size: 18px !important;
            }

            .print-template p {
                line-height: normal !important;
            }

            .contact-name {
                font-weight: 600 !important;
            }
        </style>
    @endif

    <div class="row">
        <div class="col-100">
            <div class="text text-dark">
                @stack('title_input_start')
                <h3>
                    {{ $textDocumentTitle }}
                </h3>
                @stack('title_input_end')
            </div>
        </div>
    </div>

    <div class="row border-bottom-1">
        <div class="col-58">
            <div class="text">
                @stack('company_logo_input_start')
                @if (! $hideCompanyLogo)
                    @if (! empty($document->contact->logo) && ! empty($document->contact->logo->id))
                        <img class="d-logo" src="{{ $logo }}" alt="{{ $document->contact_name }}"/>
                    @else
                        <img class="d-logo" src="{{ $logo }}" alt="{{ setting('company.name') }}"/>
                    @endif
                @endif
                @stack('company_logo_input_end')
            </div>
        </div>

        <div class="col-42">
            <div class="text right-column">
                @stack('company_details_start')
                @if ($textDocumentSubheading)
                    <p class="text-normal font-semibold">
                        {{ $textDocumentSubheading }}
                    </p>
                @endif

                @if (! $hideCompanyDetails)
                
                    @stack('company_name_input_start')
                    @if (! $hideCompanyName)
                        <p>{{ setting('company.name') }}</p>
                    @endif
                    @stack('company_name_input_end')

                    
                    {{--@stack('company_address_input_start')
                    @if (! $hideCompanyAddress)
                        <p>
                            {!! nl2br(setting('company.address')) !!}
                            {!! $document->company->location !!}
                        </p>
                    @endif
                    @stack('company_address_input_end')--}}

                    @stack('company_phone_input_start')
                    @if (! $hideCompanyPhone)
                        @if (setting('company.phone'))
                            <p>
                                {{ setting('company.phone') }}
                            </p>
                        @endif
                    @endif
                    @stack('company_phone_input_end')

                    @stack('company_email_input_start')
                    @if (! $hideCompanyEmail)
                        <p>{{ setting('company.email') }}</p>
                    @endif
                    @stack('company_email_input_end')
                @endif
                @stack('company_details_end')
            </div>
        </div>
    </div>

    <div class="row top-spacing">
        <div class="col-60">
            <div class="text p-index-left break-words">
                {{--@if (! $hideContactInfo)
                    <p class="font-semibold font mb-0">
                        {{ trans($textContactInfo) }}
                    </p>
                @endif--}}

                @stack('name_input_start')
                    @if (! $hideContactName)
                        @if ($print)
                            <p class="contact-name">
                                {{ $document->contact_name }}
                            </p>
                        @else
                            <x-link href="{{ route($showContactRoute, $document->contact_id) }}"
                                override="class"
                                class="py-1.5 mb-3 sm:mb-0 text-xs bg-transparent hover:bg-transparent font-medium leading-6"
                            >
                                <x-link.hover>
                                    {{ $document->contact_name }}
                                </x-link.hover>
                            </x-link>
                            <br>
                        @endif
                    @endif
                @stack('name_input_end')

                @stack('address_input_start')
                    @if (! $hideContactAddress)
                        <p>
                            {!! nl2br($document->contact_address) !!}
                            @php
                                $contact_location_no_country = $document->contact ? $document->contact->getFormattedAddress($document->contact->city, null, $document->contact->state, $document->contact->zip_code) : null;
                            @endphp
                            @if ($contact_location_no_country)
                                <br>
                                {!! $contact_location_no_country !!}
                            @endif
                        </p>
                    @endif
                @stack('address_input_end')

                @stack('phone_input_start')
                    @if (! $hideContactPhone)
                        @if ($document->contact_phone)
                            <p>
                                {{ $document->contact_phone }}
                            </p>
                        @endif
                    @endif
                @stack('phone_input_end')

                @stack('email_start')
                    @if (! $hideContactEmail)
                        <p class="small-text">
                            {{ $document->contact_email }}
                        </p>
                    @endif
                @stack('email_input_end')
            </div>
        </div>

        <div class="col-40">
            <div class="text p-index-right">
                @stack('order_number_input_start')
                    @if($document->order_number ?? false)
                        @if(!empty($print) && $print)
                            <p class="mb-0 clearfix">
                                <span class="font-semibold spacing w-numbers">
                                    {{ trans($textOrderNumber) }}:
                                </span>
                                <span class="float-right spacing order-max-width right-column">
                                    {{ $document->order_number }}
                                </span>
                            </p>
                        @else
                            <div class="mb-0 flex justify-between items-center">
                                <span class="font-semibold spacing">
                                    {{ trans($textOrderNumber) }}:
                                </span>
                                <span class="spacing text-right order-max-width">
                                    {{ $document->order_number }}
                                </span>
                            </div>
                        @endif
                    @endif
                @stack('order_number_input_end')

                @stack('order_date_input_start')
                    @if($document->issued_at ?? false)
                        @if(!empty($print) && $print)
                            <p class="mb-0">
                                <span class="font-semibold spacing w-numbers">
                                    {{ __('Order Date') }}:
                                </span>
                                <span class="float-right spacing order-max-width right-column">
                                    @date($document->issued_at)
                                </span>
                            </p>
                        @else
                            <div class="mb-0 flex justify-between items-center">
                                <span class="font-semibold spacing">
                                    {{ __('Order Date') }}:
                                </span>
                                <span class="spacing text-right order-max-width">
                                    @date($document->issued_at)
                                </span>
                            </div>
                        @endif
                    @endif
                @stack('order_date_input_end')
            </div>
        </div>

    @if (! $hideItems)
        <div class="row">
            <div class="col-100">
                <div class="text extra-spacing">
                    <table class="lines lines-radius-border">
                        <thead style="background-color:{{ $backgroundColor }} !important; -webkit-print-color-adjust: exact;">
                            <tr>
                                @stack('name_th_start')
                                    @if (! $hideItems || (! $hideName && ! $hideDescription))
                                        <td class="item text font-semibold text-alignment-left text-left text-white">
                                            <span>
                                                {{ (trans_choice($textItems, 2) != $textItems) ? trans_choice($textItems, 2) : trans($textItems) }}
                                            </span>
                                        </td>
                                    @endif
                                @stack('name_th_end')

                                @stack('quantity_th_start')
                                    @if (! $hideQuantity)
                                        <td class="quantity text font-semibold text-alignment-right text-right text-white">
                                            <span>
                                                {{ trans($textQuantity) }}
                                            </span>
                                        </td>
                                    @endif
                                @stack('quantity_th_end')

                                @stack('price_th_start')
                                    @if (! $hidePrice)
                                        <td class="price text font-semibold text-alignment-right text-right text-white">
                                            <span>
                                                {{ trans($textPrice) }}
                                            </span>
                                        </td>
                                    @endif
                                @stack('price_th_end')

                                @if (! $hideDiscount)
                                    @if (in_array(setting('localisation.discount_location', 'total'), ['item', 'both']))
                                        @stack('discount_td_start')
                                            <td class="discount text font-semibold text-alignment-right text-right text-white">
                                                <span>
                                                    {{ trans('invoices.discount') }}
                                                </span>
                                            </td>
                                        @stack('discount_td_end')
                                    @endif
                                @endif

                                @stack('total_th_start')
                                    @if (! $hideAmount)
                                        <td class="total text font-semibold text-white text-alignment-right text-right">
                                            <span>
                                                {{ trans($textAmount) }}
                                            </span>
                                        </td>
                                    @endif
                                @stack('total_th_end')
                            </tr>
                        </thead>

                        <tbody>
                            @if ($document->items->count())
                                @foreach($document->items as $item)
                                    <x-documents.template.line-item
                                        type="{{ $type }}"
                                        :item="$item"
                                        :document="$document"
                                        hide-items="{{ $hideItems }}"
                                        hide-name="{{ $hideName }}"
                                        hide-description="{{ $hideDescription }}"
                                        hide-quantity="{{ $hideQuantity }}"
                                        hide-price="{{ $hidePrice }}"
                                        hide-discount="{{ $hideDiscount }}"
                                        hide-amount="{{ $hideAmount }}"
                                    />
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text text-center empty-items">
                                        {{ trans('documents.empty_items') }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <div class="row mt-9 clearfix">
        <div class="col-60 float-left">
            <div class="text p-index-left break-words">
                @stack('notes_input_start')
                    @if ($document->notes)
                        <p class="font-semibold">
                            {{ trans_choice('general.notes', 2) }}
                        </p>

                        {!! nl2br($document->notes) !!}
                    @endif
                @stack('notes_input_end')
            </div>
        </div>

        <div class="col-40 float-right text-right">
            @foreach ($document->totals_sorted as $total)
                @if ($total->code == 'item_discount')
                    @continue
                @endif

                @if ($total->code == 'shipping' && (! empty($pdf) || ! empty($print)))
                    @continue
                @endif

                @if ($total->code != 'total')
                    @stack($total->code . '_total_tr_start')
                    <div class="text border-bottom-1 py-1">
                        <span class="float-left font-semibold">
                            {{ trans($total->title) }}:
                        </span>

                        <span>
                            Tk {{ number_format($total->amount, 0) }}
                        </span>
                    </div>
                    @stack($total->code . '_total_tr_end')
                @else
                    @if ($document->paid)
                        @stack('paid_total_tr_start')
                        <div class="text border-bottom-1 py-1">
                            <span class="float-left font-semibold">
                                {{ trans('invoices.paid') }}:
                            </span>

                            <span>
                                Tk {{ number_format($document->paid, 0) }}
                            </span>
                        </div>
                        @stack('paid_total_tr_end')
                    @endif

                    @stack('grand_total_tr_start')
                    <div class="text border-bottom-1 py-1">
                        <span class="float-left font-semibold">
                            {{ trans($total->name) }}:
                        </span>

                        <span>
                            Tk {{ number_format($document->amount_due, 0) }}
                        </span>
                    </div>
                    @stack('grand_total_tr_end')
                @endif
            @endforeach
        </div>
    </div>

    @if (! $hideFooter)
        @if ($document->footer)
        @stack('footer_input_start')
            <div class="row mt-4">
                <div class="col-100 text-left">
                    <div class="text">
                        <span class="font-bold">
                            {!! nl2br($document->footer) !!}
                        </span>
                    </div>
                </div>
            </div>
        @stack('footer_input_end')
        @endif
    @endif
</div>