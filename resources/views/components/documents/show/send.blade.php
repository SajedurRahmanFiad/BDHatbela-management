<x-show.accordion type="send" :open="($accordionActive == 'send')">
    <x-slot name="head">
        <x-show.accordion.head
            title="{{ trans('dynamic.process') }}"
            description="{!! trans($description, [
                'user' => $user_name,
                'type' => $type_lowercase,
                'date' => $last_sent_date,
            ]) !!}"
        />
    </x-slot>

    <x-slot name="body">
        @stack('timeline_send_body_start')

        <div class="flex flex-wrap space-x-3 rtl:space-x-reverse">


            @stack('timeline_send_body_button_mark_sent_start')

            @if (! $hideMarkSent)
                @can($permissionUpdate)
                    @if ($document->status == 'draft')
                        <x-link id="show-slider-actions-mark-sent-{{ $document->type }}" href="{{ route($markSentRoute, $document->id) }}" @click="e => e.target.classList.add('disabled')">
                            <x-link.loading>
                                {{ trans($textMarkSent) }}
                            </x-link.loading>
                        </x-link>
                    @endif
                @endcan
            @endif

            @stack('timeline_send_body_button_cancelled_start')

            @if (! $hideShare && !(user() && user()->isEmployee()))
                @if ($document->status != 'cancelled')
                    <x-button id="show-slider-actions-share-link-{{ $document->type }}" @click="onShareLink('{{ route($shareRoute, $document->id) }}')">
                        {{ trans('general.share_link') }}
                    </x-button>
                @endif
            @endif

            @if ($document->type == 'invoice' && $document->status == 'sent' && !$document->histories->where('status', 'steadfast_sent')->first())
                <x-link href="{{ route('invoices.send-to-steadfast', $document->id) }}" id="show-more-actions-send-to-steadfast-{{ $document->type }}">
                    Add to Steadfast
                </x-link>
            @endif

            @stack('timeline_send_body_button_cancelled_end')

            @stack('timeline_send_body_history_start')

            @php $allHistories = $document->histories->whereIn('status', ['sent', 'steadfast_sent'])->sortBy('created_at'); @endphp
            @if ($allHistories->count())
                <div class="text-xs mt-6" style="margin-left: 0 !important;">
                    <span class="font-medium">
                        {{ trans_choice('general.histories', 1) }}:
                    </span>

                    @foreach ($allHistories as $history)
                        <div class="my-4">
                            <span>
                                @if($history->status == 'sent')
                                    {{ $history->owner->name }} added this {{ $type_lowercase }} for processing on {{ company_date($history->created_at) }} at {{ $history->created_at->format('h:i A') }}
                                @else
                                    {{ $history->owner->name }} added this {{ $type_lowercase }} to Steadfast on {{ company_date($history->created_at) }} at {{ $history->created_at->format('h:i A') }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif

            @stack('timeline_send_body_history_end')
        </div>

        @stack('timeline_get_paid_body_end')
    </x-slot>
</x-show.accordion>
