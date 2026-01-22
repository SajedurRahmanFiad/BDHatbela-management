<?php

namespace App\Jobs\Banking;

use App\Abstracts\Job;
use App\Events\Banking\DocumentTransactionCreated;
use App\Events\Banking\DocumentTransactionCreating;
use App\Jobs\Banking\CreateTransaction;
use App\Jobs\Document\CreateDocumentHistory;
use App\Events\Document\PaidAmountCalculated;
use App\Interfaces\Job\ShouldCreate;
use App\Models\Banking\Account;
use App\Models\Banking\Transaction;
use App\Models\Document\Document;
use App\Models\Setting\Category;
use App\Traits\Currencies;
use App\Utilities\Date;
use App\Utilities\TransactionNumber;

class CreateBankingDocumentTransaction extends Job implements ShouldCreate
{
    use Currencies;

    protected $transaction;
    protected $received;

    public function __construct(Document $model, $request)
    {
        $this->model = $model;

        parent::__construct($request);
    }

    public function handle(): Transaction
    {
        $previous_paid = $this->model->paid;

        event(new DocumentTransactionCreating($this->model, $this->request));

        $this->prepareRequest();

        $this->received = $this->request['amount'];
        $this->request['amount'] = $this->model->amount;

        $this->checkAmount();

        \DB::transaction(function () {
            $this->transaction = $this->dispatch(new CreateTransaction($this->request));

            $this->model->save();

            $this->createHistory();
        });

        // Check if payment is partial and create shipping expense
        $new_paid = $previous_paid + $this->received;
        if ($new_paid < $this->model->amount) {
            $difference = $this->model->amount - $this->received;

            $cash_account = Account::where('name', 'Cash')->where('company_id', $this->model->company_id)->first();
            if (!$cash_account) {
                $cash_account = Account::find(setting('default.account'));
            }
            $shipping_category = Category::where('name', 'Shipping Costs')->where('company_id', $this->model->company_id)->first();
            if (!$shipping_category) {
                // Create the category if not exists
                $shipping_category = Category::create([
                    'company_id' => $this->model->company_id,
                    'name' => 'Shipping Costs',
                    'type' => 'expense',
                    'color' => '#ff0000', // some color
                    'enabled' => 1,
                ]);
            }

            if ($cash_account && $shipping_category) {
                $expense_request = [
                    'type' => 'expense',
                    'company_id' => $this->model->company_id,
                    'paid_at' => Date::now()->toDateTimeString(),
                    'amount' => $difference,
                    'account_id' => $cash_account->id,
                    'payment_method' => 'Cash',
                    'category_id' => $shipping_category->id,
                    'currency_code' => $this->model->currency_code,
                    'currency_rate' => $this->model->currency_rate,
                    'description' => 'Shipping cost for invoice ' . $this->model->document_number,
                    'number' => app(TransactionNumber::class)->getNextNumber('expense', '', null),
                    'created_from' => 'core::ui',
                    'created_by' => 1, // assuming admin
                ];

                $this->dispatch(new CreateTransaction($expense_request));
            }
        }

        event(new DocumentTransactionCreated($this->model, $this->transaction));

        return $this->transaction;
    }

    protected function prepareRequest(): void
    {
        if (!isset($this->request['amount'])) {
            $this->model->paid_amount = $this->model->paid;
            event(new PaidAmountCalculated($this->model));

            $this->request['amount'] = $this->model->amount - $this->model->paid_amount;
        }

        $currency_code = !empty($this->request['currency_code']) ? $this->request['currency_code'] : $this->model->currency_code;

        $this->request['company_id'] = $this->model->company_id;
        $this->request['currency_code'] = $currency_code;
        $this->request['paid_at'] = isset($this->request['paid_at']) ? $this->request['paid_at'] : Date::now()->toDateTimeString();
        $this->request['currency_rate'] = isset($this->request['currency_rate']) ? $this->request['currency_rate'] : currency($currency_code)->getRate();
        $this->request['account_id'] = isset($this->request['account_id']) ? $this->request['account_id'] : setting('default.account');
        $this->request['document_id'] = isset($this->request['document_id']) ? $this->request['document_id'] : $this->model->id;
        $this->request['contact_id'] = isset($this->request['contact_id']) ? $this->request['contact_id'] : $this->model->contact_id;
        $this->request['category_id'] = isset($this->request['category_id']) ? $this->request['category_id'] : $this->model->category_id;
        $this->request['payment_method'] = isset($this->request['payment_method']) ? $this->request['payment_method'] : setting('default.payment_method');
        $this->request['notify'] = isset($this->request['notify']) ? $this->request['notify'] : 0;
    }

    protected function checkAmount(): bool
    {
        $code = $this->request['currency_code'];
        $rate = $this->request['currency_rate'];

        $precision = currency($code)->getPrecision();

        $amount = $this->request['amount'] = round($this->request['amount'], $precision);

        if ($this->model->currency_code != $code) {
            $converted_amount = $this->convertBetween($amount, $code, $rate, $this->model->currency_code, $this->model->currency_rate);

            $amount = round($converted_amount, $precision);
        }

        $this->model->paid_amount = $this->model->paid;
        event(new PaidAmountCalculated($this->model));

        $total_amount = round($this->model->amount - $this->model->paid_amount, $precision);

        unset($this->model->reconciled);
        unset($this->model->paid_amount);

        $received_rounded = round($this->received, $precision);
        $compare = bccomp($received_rounded, $total_amount, $precision);

        // Always set status to 'paid' after any payment
        $this->model->status = 'paid';

        return true;
    }

    protected function createHistory(): void
    {
        $history_desc = money((double) $this->transaction->amount, (string) $this->transaction->currency_code)->format() . ' ' . trans_choice('general.payments', 1);

        $this->dispatch(new CreateDocumentHistory($this->model, 0, $history_desc));
    }
}
