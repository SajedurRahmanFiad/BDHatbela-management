<x-table>
    <x-table.thead>
        <x-table.tr>
            @if (! $hideBulkAction)
            <x-table.th class="{{ $classBulkAction }}" override="class">
                <x-index.bulkaction.all />
            </x-table.th>
            @endif

            @stack('contact_name_ane_document_number_th_start')
            @if (! $hideContactName || ! $hideDocumentNumber)
            <x-table.th class="{{ $classContactNameAndDocumentNumber }}">
                @stack('contact_name_th_start')
                @if (! $hideContactName)
                <x-slot name="first">
                    @stack('contact_name_th_inside_start')
                    <x-sortablelink column="contact_name" title="{{ trans_choice($textContactName, 1) }}" />
                    @stack('contact_name_th_inside_end')
                </x-slot>
                @endif
                @stack('contact_name_th_end')

                @stack('document_number_th_start')
                @if (! $hideDocumentNumber)
                <x-slot name="second">
                    @stack('document_number_th_inside_start')
                    {{-- No header caption for document number --}}
                    @stack('document_number_th_inside_end')
                </x-slot>
                @endif
                @stack('document_number_th_end')
            </x-table.th>
            @endif
            @stack('contact_name_ane_document_number_th_end')

            @stack('due_at_and_issued_at_th_start')
            @if (! $hideDueAt || ! $hideIssuedAt)
            <x-table.th class="{{ $classDueAtAndIssueAt }}">
                @stack('due_at_th_start')
                @if (! $hideDueAt)
                <x-slot name="first">
                    @stack('due_at_th_inside_start')
                    {{-- No header caption for due date --}}
                    @stack('due_at_th_inside_end')
                </x-slot>
                @endif
                @stack('due_at_th_end')

                @stack('issued_at_th_start')
                @if (! $hideIssuedAt)
                <x-slot name="second">
                    @stack('issued_at_th_inside_start')
                    <x-sortablelink column="issued_at" title="{{ __('Created At') }}" />
                    @stack('issued_at_th_inside_end')
                </x-slot>
                @endif
                @stack('issued_at_th_end')
            </x-table.th>
            @endif
            @stack('due_at_and_issued_at_th_end')

            @stack('status_th_start')
            @if (! $hideStatus)
            <x-table.th class="{{ $classStatus }}">
                @stack('status_th_inside_start')
                <x-sortablelink column="status" title="{{ trans_choice('general.statuses', 1) }}" />
                @stack('status_th_inside_end')
            </x-table.th>
            @endif
            @stack('status_th_end')

            @stack('created_by_th_start')
            @if ($type === 'invoice')
            <x-table.th class="{{ $classCreatedBy ?? '' }}">
                <x-slot name="first" class="w-48 font-normal truncate" override="class">
                    {{ __('Created by') }}
                </x-slot>
            </x-table.th>
            @endif
            @stack('created_by_th_end')

            @stack('amount_th_start')
            @if (! $hideAmount)
            <x-table.th class="{{ $classAmount }}" kind="amount">
                @stack('amount_th_inside_start')
                <x-sortablelink column="amount" title="{{ trans('general.amount') }}" />
                @stack('amount_th_inside_end')
            </x-table.th>
            @endif
            @stack('amount_th_end')
        </x-table.tr>
    </x-table.thead>

    <x-table.tbody>
        @foreach($documents as $item)
            @php $paid = $item->paid; @endphp
            <x-table.tr href="{{ route($showRoute, $item->id) }}">
                @if (! $hideBulkAction)
                <x-table.td class="{{ $classBulkAction }}" override="class">
                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->document_number }}" />
                </x-table.td>
                @endif

                @stack('contact_name_and_document_number_td_start')
                @if (! $hideContactName || ! $hideDocumentNumber)
                <x-table.td class="{{ $classContactNameAndDocumentNumber }}">
                    @stack('contact_name_td_start')
                    @if (! $hideContactName)
                    <x-slot name="first">
                        @stack('contact_name_td_inside_start')
                        {{ $item->contact_name }}
                        @stack('contact_name_td_inside_end')
                    </x-slot>
                    @endif
                    @stack('contact_name_td_end')

                    @stack('document_number_td_start')
                    @if (! $hideDocumentNumber)
                    <x-slot name="second" class="w-20 group" data-tooltip-target="tooltip-information-{{ $item->id }}" data-tooltip-placement="left" override="class">
                        @stack('document_number_td_inside_start')
                        <span class="border-black border-b border-dashed">
                            {{ $item->document_number }}
                        </span>

                        <div class="w-28 absolute h-10 -ml-12 -mt-6"></div>
                        @stack('document_number_td_inside_end')

                        <x-documents.index.information :document="$item" :hide-show="$hideShow" :show-route="$showContactRoute" />
                    </x-slot>
                    @endif
                    @stack('document_number_td_end')
                </x-table.td>
                @endif
                @stack('contact_name_and_document_number_td_end')

                @stack('due_at_and_issued_at_td_start')
                @if (! $hideDueAt || ! $hideIssuedAt)
                <x-table.td class="{{ $classDueAtAndIssueAt }}">
                    @stack('due_at_td_start')
                    @if (! $hideDueAt)
                    <x-slot name="first" class="font-bold" override="class">
                        @stack('due_at_td_inside_start')
                        <x-date :date="$item->created_at" function="diffForHumans" />
                        @stack('due_at_td_inside_end')
                    </x-slot>
                    @endif
                    @stack('due_at_td_end')

                    @stack('issued_at_td_start')
                    @if (! $hideIssuedAt)
                    <x-slot name="second">
                        @stack('issued_at_td_inside_start')
                        <x-date date="{{ $item->issued_at }}" />
                        @stack('issued_at_td_inside_end')
                    </x-slot>
                    @endif
                    @stack('issued_at_td_end')
                </x-table.td>
                @endif
                @stack('due_at_and_issued_at_td_end')

                @stack('status_td_start')
                @if (!$hideStatus)
                    <x-table.td class="{{ $classStatus }}">
                        @stack('status_td_inside_start')
                        <div class="flex items-center">
                            <x-show.status status="{{ $item->status }}" background-color="bg-{{ $item->status_label }}" text-color="text-text-{{ $item->status_label }}" />
                            @if ($item->histories->where('status', 'steadfast_sent')->first() && !in_array($item->status, ['paid', 'picked', 'cancelled']))
                                <img src="{{ asset('public/img/steadfast.png') }}" alt="Steadfast" title="Added to Steadfast" class="w-5 h-5 ml-2" />
                            @endif
                            @if ($item->histories->where('status', 'carrybee_sent')->first() && !in_array($item->status, ['paid', 'picked', 'cancelled']))
                                <img src="{{ asset('public/img/carrybee.png') }}" alt="CarryBee" title="Added to CarryBee" class="w-5 h-5 ml-2" />
                            @endif
                        </div>
                        @stack('status_td_inside_end')
                    </x-table.td>
                @endif
                @stack('status_td_end')

                @stack('created_by_td_start')
                @if ($type === 'invoice')
                <x-table.td class="{{ $classCreatedBy ?? '' }}">
                    <x-slot name="second" class="w-48 font-normal truncate" override="class">
                        <span title="{{ $item->owner->name }}">{{ $item->owner->name }}</span>
                    </x-slot>
                </x-table.td>
                @endif
                @stack('created_by_td_end')

                @stack('amount_td_start')
                @if (! $hideAmount)
                <x-table.td class="{{ $classAmount }}" kind="amount">
                    @stack('amount_td_inside_start')
                    <x-money :amount="$item->amount" :currency="$item->currency_code" />
                    @stack('amount_td_inside_end')
                </x-table.td>

                <x-table.td kind="action">
                    <x-table.actions :model="$item" />
                </x-table.td>
                @endif
                @stack('amount_td_end')
            </x-table.tr>
        @endforeach
    </x-table.tbody>
</x-table>

<x-pagination :items="$documents" />
