<?php

namespace App\Jobs\Document;

use App\Abstracts\Job;
use App\Events\Document\PaidAmountCalculated;
use App\Events\Document\DocumentUpdated;
use App\Events\Document\DocumentUpdating;
use App\Interfaces\Job\ShouldUpdate;
use App\Jobs\Document\CreateDocumentItemsAndTotals;
use App\Models\Document\Document;
use App\Traits\Relationships;
use Illuminate\Support\Str;

class UpdateDocument extends Job implements ShouldUpdate
{
    use Relationships;

    public function handle(): Document
    {
        if (empty($this->request['amount'])) {
            $this->request['amount'] = 0;
        }

        // Disable this lines for global discount issue fixed ( https://github.com/akaunting/akaunting/issues/2797 )
        $this->request['discount_rate'] = $this->request['discount'] ?? null;

        event(new DocumentUpdating($this->model, $this->request));

        \DB::transaction(function () {
            // Upload attachment
            if ($this->request->file('attachment')) {
                $this->deleteMediaModel($this->model, 'attachment', $this->request);

                foreach ($this->request->file('attachment') as $attachment) {
                    $media = $this->getMedia($attachment, Str::plural($this->model->type));

                    $this->model->attachMedia($media, 'attachment');
                }
            } elseif ($this->request->isNotApi() && ! $this->request->file('attachment') && $this->model->attachment) {
                $this->deleteMediaModel($this->model, 'attachment', $this->request);
            } elseif ($this->request->isApi() && $this->request->has('remove_attachment') && $this->model->attachment) {
                $this->deleteMediaModel($this->model, 'attachment', $this->request);
            }

            // Preserve existing document item purchase_price snapshots when updating
            // If the incoming request items do not explicitly provide a purchase_price, copy it from
            // the existing document items (matched by position). This prevents accidental COGS changes
            // when a document is updated without changing its item lines.
            if (isset($this->request['items']) && is_array($this->request['items'])) {
                $items = $this->request->get('items', []);
                $existing_items = $this->model->items->values()->all();

                foreach ($items as $index => $req_item) {
                    if (! isset($req_item['purchase_price'])) {
                        $existing = $existing_items[$index] ?? null;

                        if ($existing) {
                            $items[$index]['purchase_price'] = $existing->purchase_price ?? ($existing->item->purchase_price ?? null);
                        }
                    }
                }

                // Merge modified items back into the request to avoid indirect modification on the FormRequest object
                $this->request->merge(['items' => $items]);
            }

            // Preserve existing shipping amount (prefer value stored on document). UpdateDocument deletes
            // all totals and re-creates them from the incoming request, so if the client omits the
            // shipping value we should preserve the current shipping amount to avoid accidental removal.
            $existingShipping = $this->model->shipping ?? $this->model->totals()->code('shipping')->sum('amount');

            if ($existingShipping > 0) {
                $hasShippingInRequest = false;

                if (! empty($this->request['shipping']) && (float) $this->request['shipping'] > 0) {
                    $hasShippingInRequest = true;
                }

                if (! $hasShippingInRequest && ! empty($this->request['totals'])) {
                    foreach ($this->request['totals'] as $t) {
                        if (! empty($t['code']) && $t['code'] === 'shipping') {
                            $hasShippingInRequest = true;
                            break;
                        }
                    }
                }

                if (! $hasShippingInRequest) {
                    $this->request->merge(['shipping' => $existingShipping]);
                }
            }

            $this->deleteRelationships($this->model, ['items', 'item_taxes', 'totals'], true);

            $this->dispatch(new CreateDocumentItemsAndTotals($this->model, $this->request));

            $this->model->paid_amount = $this->model->paid;

            event(new PaidAmountCalculated($this->model));

            if ($this->model->paid_amount > 0) {
                if ($this->request['amount'] == $this->model->paid_amount) {
                    $this->request['status'] = 'paid';
                }

                if ($this->request['amount'] > $this->model->paid_amount) {
                    $this->request['status'] = 'partial';
                }
            }

            unset($this->model->reconciled);
            unset($this->model->paid_amount);

            $this->model->update($this->request->all());

            $this->model->updateRecurring($this->request->all());
        });

        event(new DocumentUpdated($this->model, $this->request));

        return $this->model;
    }
}
