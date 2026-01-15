<?php

namespace App\Listeners\Banking;

use App\Events\Banking\TransactionCreated as Event;
use App\Notifications\Admin\AdminActivity;
use App\Models\Document\Document;

class NotifyAdminsOnTransactionCreated
{
    public function handle(Event $event)
    {
        $transaction = $event->transaction;

        if (empty($transaction->created_by)) {
            return;
        }

        // Only notify on expenses and bills
        if (! $transaction->isExpense() && (empty($transaction->document) || $transaction->document->type !== Document::BILL_TYPE)) {
            return;
        }

        $actor = user_model_class()::find($transaction->created_by);

        if (empty($actor) || ! $actor->can('read-admin-panel')) {
            return;
        }

        // Determine action and url
        if ($transaction->isTransferTransaction()) {
            $action = trans('notifications.admin.activity.title', ['actor' => $actor->name, 'action' => trans('general.created_transfer')]);
            $url = optional($transaction->transfer)->url ?? route('transactions.show', $transaction->id);
            $model = $transaction->transfer ?? $transaction;
        } else if ($transaction->isExpense()) {
            $action = trans('general.created_expense');
            $url = route('transactions.show', $transaction->id);
            $model = $transaction;
        } else {
            $action = trans('general.created_transaction');
            $url = route('transactions.show', $transaction->id);
            $model = $transaction;
        }

        foreach ($transaction->company->users as $user) {
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
