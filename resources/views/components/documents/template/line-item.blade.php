<tr class="line-item-row">
    @stack($item->id . '_line_item_start')

    @stack('name_td_start')
        @if (! $hideItems || (! $hideName && ! $hideDescription))
            <td class="item text text-alignment-left text-left max-w-0">
                <div style="display: flex; align-items: center; gap: 8px;">
                    @php
                        $related = $item->item ?? null;
                        $picture = null;

                        if ($related && isset($related->picture) && $related->picture) {
                            $picture = $related->picture;
                        }
                    @endphp

                    @if ($picture)
                        @php
                            if (is_object($picture) && isset($picture->id)) {
                                // When generating PDFs, prefer local absolute path so dompdf can access the file
                                if (! empty($pdf) && $pdf && method_exists($picture, 'getAbsolutePath')) {
                                    $pictureUrl = 'file://' . $picture->getAbsolutePath();
                                } else {
                                    $pictureUrl = route('uploads.get', $picture->id);
                                }
                            } elseif (is_numeric($picture)) {
                                if (! empty($pdf) && $pdf) {
                                    try {
                                        $media = \App\Models\Common\Media::find($picture);

                                        if ($media && method_exists($media, 'getAbsolutePath')) {
                                            $pictureUrl = 'file://' . $media->getAbsolutePath();
                                        } else {
                                            $pictureUrl = url('/' . company_id()) . '/uploads/' . $picture;
                                        }
                                    } catch (\Exception $e) {
                                        $pictureUrl = url('/' . company_id()) . '/uploads/' . $picture;
                                    }
                                } else {
                                    $pictureUrl = url('/' . company_id()) . '/uploads/' . $picture;
                                }
                            } else {
                                $pictureUrl = $picture;
                            }
                        @endphp

                        <img src="{{ $pictureUrl }}" alt="{{ $item->name }}" style="width: 60px; height: 60px; margin-right: 5px; border-radius: 50%; object-fit: cover; border: 1px solid #d1d5db;" />
                    @else
                        @php
                            if ($related && isset($related->initials)) {
                                $initials = $related->initials;
                            } else {
                                $words = preg_split('/\\s+/', trim($item->name));

                                if (count($words) >= 2) {
                                    $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                } else {
                                    $initials = strtoupper(substr($item->name, 0, 1));
                                }
                            }
                        @endphp

                        @if (! empty($print) && $print)
                            {{-- no avatar or placeholder in PDF output --}}
                        @else
                            <div style="width: 60px; height: 60px; margin-right: 5px; border-radius: 50%; border: 1px solid #d1d5db; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 500; flex-shrink: 0; line-height: 56px; text-align: center; box-sizing: border-box; overflow: hidden;">
                                {{ $initials }}
                            </div>
                        @endif
                    @endif
                    <div>
                        @if (! $hideName)
                            {{ $item->name }} <br/>
                        @endif

                        @if (! $hideDescription)
                            @if (! empty($item->description))
                                <div class="small-text break-words">
                                    {!! \Illuminate\Support\Str::limit(nl2br($item->description), 500) !!}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                @stack('item_custom_fields')
                @stack('item_custom_fields_' . $item->id)
            </td>
        @endif
    @stack('name_td_end')

    @stack('quantity_td_start')
        @if (! $hideQuantity)
            <td class="quantity text text-alignment-right text-right">
                {{ $item->quantity }}
            </td>
        @endif
    @stack('quantity_td_end')

    @stack('price_td_start')
        @if (! $hidePrice)
            <td class="price text text-alignment-right text-right">
                <span>Tk {{ number_format($item->price, 0) }}</span>
            </td>
        @endif
    @stack('price_td_end')

    @if (! $hideDiscount)
        @if (in_array(setting('localisation.discount_location', 'total'), ['item', 'both']))
            @stack('discount_td_start')
                @if ($item->discount_type === 'percentage')
                    <td class="discount text text-alignment-right text-right">
                        @php
                            $text_discount = '';

                            if (setting('localisation.percent_position') == 'before') {
                                $text_discount .= '%';
                            }

                            $text_discount .= $item->discount;

                            if (setting('localisation.percent_position') == 'after') {
                                $text_discount .= '%';
                            }
                        @endphp

                        {{ $text_discount }}
                    </td>
                @else
                    <td class="discount text text-alignment-right text-right">
                        <span>Tk {{ number_format($item->discount, 0) }}</span>
                    </td>
                @endif
            @stack('discount_td_end')
        @endif
    @endif

    @stack('total_td_start')
        @if (! $hideAmount)
            <td class="total text text-alignment-right text-right">
                <span>Tk {{ number_format($item->total, 0) }}</span>
            </td>
        @endif
    @stack('total_td_end')

    @stack($item->id . '_line_item_end')
</tr>
