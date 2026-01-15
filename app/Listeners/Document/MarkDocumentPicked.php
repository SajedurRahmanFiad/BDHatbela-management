<?php

namespace App\Listeners\Document;

use App\Events\Document\DocumentMarkedPicked;
use App\Jobs\Document\CreateDocumentHistory;
use App\Traits\Jobs;

class MarkDocumentPicked
{
    use Jobs;

    public function handle(DocumentMarkedPicked $event): void
    {
        // Only allow marking as picked when the order is currently in one of the
        // "processing" states. For invoices this corresponds to sent/viewed/partial,
        // which are what Akaunting treats as "unpaid" in filters.
        if (! in_array($event->document->status, ['sent', 'viewed', 'partial'])) {
            return;
        }

        $event->document->status = 'picked';
        $event->document->save();

        $this->dispatch(new CreateDocumentHistory($event->document, 0, $this->getDescription($event)));
    }

    public function getDescription(DocumentMarkedPicked $event): string
    {
        $type_text = '';

        if ($alias = config('type.document.' . $event->document->type . '.alias', '')) {
            $type_text .= $alias . '::';
        }

        $type_text .= 'general.' . config('type.document.' . $event->document->type .'.translation.prefix');

        $type = trans_choice($type_text, 1);

        return trans('documents.messages.marked_as', ['type' => $type, 'status' => trans('documents.statuses.picked')]);
    }
}
