<?php

namespace App\Listeners\Document;

use App\Events\Document\DocumentCreated as Event;
use App\Notifications\Admin\AdminActivity;
use App\Models\Document\Document;

class NotifyAdminsOnDocumentCreated
{
    public function handle(Event $event)
    {
        $document = $event->document;

        if ($document->type !== Document::BILL_TYPE) {
            return;
        }

        $actor = user_model_class()::find($document->created_by);

        if (empty($actor) || ! $actor->can('read-admin-panel')) {
            return;
        }

        $action = trans('general.created_bill');
        // Use the admin bill route (was referencing non-existent documents.show)
        $url = route('bills.show', $document->id);
        $model = $document;

        foreach ($document->company->users as $user) {
            if ($user->id == $actor->id) {
                continue;
            }

            if ($user->cannot('read-notifications')) {
                continue;
            }

            $user->notify(new AdminActivity($actor, $action, $model, $url));
        }
    }
}
