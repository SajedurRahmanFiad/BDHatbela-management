<div wire:click.stop id="menu-notifications" class="relative">
    <input type="text" name="notification_keyword" wire:model.live.debounce.500ms="keyword" placeholder="{{ trans('general.search_placeholder') }}" class="border-t-0 border-l-0 border-r-0 border-b border-gray-300 bg-transparent text-gray-500 text-sm mb-3 focus:outline-none focus:ring-transparent focus:border-purple placeholder-light-gray js-search-action">

    @if ($keyword)
        <button type="button" class="absolute ltr:right-2 rtl:left-2 top-2 clear" wire:click="resetKeyword">
            <span class="material-icons text-sm">close</span>
        </button>
    @endif

    @if ($notifications)
        <div class="flex justify-end mt-1 mb-3">
            <x-tooltip id="notification-all" placement="top" message="{{ trans('notifications.mark_read_all') }}">
                <button type="button" wire:click="markReadAll()">
                    <span id="menu-notification-read-all" class="material-icons text-lg text-purple hover:scale-125">done_all</span>
                </button>
            </x-tooltip>
        </div>

        <ul class="flex flex-col justify-center">
            @foreach ($notifications as $notification)
                @if (empty($notification->data['title']) && empty($notification->data['description']))
                    @continue
                @endif

                <li class="mb-5 border-b pb-2">
                    <div class="flex items-start justify-between font-medium text-sm text-purple mb-1">
                        <div class="flex flex-col">
                            @php
                                $url = null;
                                $data = $notification->data ?? [];

                                if (isset($data['invoice_id'])) {
                                    $doc = \App\Models\Document\Document::find($data['invoice_id']);
                                    if ($doc) {
                                        $url = route('invoices.show', ['company_id' => $doc->company_id, 'invoice' => $doc->id]);
                                    }
                                } elseif (isset($data['bill_id'])) {
                                    $doc = \App\Models\Document\Document::find($data['bill_id']);
                                    if ($doc) {
                                        $url = route('bills.show', ['company_id' => $doc->company_id, 'bill' => $doc->id]);
                                    }
                                } elseif (isset($data['transaction_id'])) {
                                    $t = \App\Models\Banking\Transaction::find($data['transaction_id']);
                                    if ($t) {
                                        $url = route('transactions.show', ['company_id' => $t->company_id, 'transaction' => $t->id]);
                                    }
                                } elseif (isset($data['url'])) {
                                    $url = $data['url'];
                                }
                            @endphp

                            @if ($url)
                                <a href="{{ $url }}" onclick="event.preventDefault(); (function(){ try { if (window.Livewire && typeof Livewire.emitTo === 'function') { Livewire.emitTo('menu.notifications', 'markRead', '{{ $notification->type }}', '{{ $notification->id }}', false); } } catch(e) {} setTimeout(function(){ window.location = '{{ $url }}'; }, 100); })();">
                                    {!! data_get($notification->data, 'title', '') !!}
                                </a>
                            @else
                                {!! data_get($notification->data, 'title', '') !!}
                            @endif

                            <span class="text-gray-500" style="font-size: 10px;">
                                {{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}
                            </span>
                        </div>

                        @if ($notification->type != 'updates')
                            <x-tooltip id="notification-{{ $notification->id }}" placement="top" message="{{ trans('notifications.mark_read') }}">
                                <button type="button" wire:click="markRead('{{ $notification->type }}', '{{ $notification->id }}')">
                                    <span id="menu-notification-read-one-{{ $notification->id }}" class="material-icons text-lg text-purple hover:scale-125">check_circle_outline</span>
                                </button>
                            </x-tooltip>
                        @endif
                    </div>

                </li>
            @endforeach
        </ul>
    @else
        <ul class="flex flex-col justify-center">
            <li class="text-sm mb-5">
                <div class="flex items-start">
                    <p class="text-black">
                        {{ trans('notifications.empty') }}
                    </p>
                </div>
            </li>
        </ul>
    @endif
</div>

@push('scripts_end')
    <script type="text/javascript">
        window.addEventListener('mark-read', event => {
            const payload = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            if (payload && (payload.type == 'notification' || payload.type == 'notifications')) {
                $.notify(payload.message, {
                    type: 'success',
                });
            }
        });

        window.addEventListener('mark-read-all', event => {
            const payload = Array.isArray(event.detail) ? event.detail[0] : event.detail;
            if (payload && (payload.type == 'notification' || payload.type == 'notifications')) {
                $.notify(payload.message, {
                    type: 'success',
                });
            }
        });
    </script>
@endpush
