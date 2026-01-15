<?php

return [

    'invoice_number'        => trans('dynamic.invoice') . ' Number',
    'invoice_date'          => trans('dynamic.invoice') . ' Date',
    'invoice_amount'        => trans('dynamic.invoice') . ' Amount',
    'total_price'           => 'Total Price',
    'due_date'              => 'Due Date',
    'order_number'          => 'Order Number',
    'bill_to'               => 'Bill To',
    'cancel_date'           => 'Cancel Date',

    'quantity'              => 'Quantity',
    'price'                 => 'Price',
    'sub_total'             => 'Subtotal',
    'discount'              => 'Discount',
    'item_discount'         => 'Line Discount',
    'tax_total'             => 'Tax Total',
    'total'                 => 'Total',

    'item_name'             => 'Item Name|Item Names',
    'recurring_invoices'    => trans('dynamic.recurring_invoice') . '|' . trans('dynamic.recurring_invoices'),

    'show_discount'         => ':discount% Discount',
    'add_discount'          => 'Add Discount',
    'discount_desc'         => 'of subtotal',

    'shipping'              => 'Shipping',
    'add_shipping'          => 'Add Shipping',
    'shipping_desc'         => '' ,

    'payment_due'           => 'Payment Due',
    'paid'                  => 'Paid',
    'histories'             => 'Histories',
    'payments'              => 'Payments',
    'add_payment'           => 'Add Payment',
    'mark_paid'             => 'Mark Paid',
    'mark_sent'             => 'Mark ' . trans('dynamic.send'),
    'mark_viewed'           => 'Mark Viewed',
    'mark_cancelled'        => 'Mark Cancelled',
    'download_pdf'          => 'Download PDF',
    'send_mail'             => 'Send Email',
    'all_invoices'          => 'Login to view all ' . trans('dynamic.invoices'),
    'create_invoice'        => 'Create ' . trans('dynamic.invoice'),
    'send_invoice'          => trans('dynamic.send') . ' ' . trans('dynamic.invoice'),
    'get_paid'              => 'Get Paid',
    'accept_payments'       => 'Accept Online Payments',
    'payments_received'     => 'Payments received',
    'over_payment'          => 'The amount you entered passes the total: :amount',

    'form_description' => [
        'billing'           => 'Billing details appear in your invoice. Invoice Date is used in the dashboard and reports. Select the date you expect to get paid as the Due Date.',
    ],

    'messages' => [
        'email_required'    => 'No email address for this customer!',
        'totals_required'   => 'Invoice totals are required. Please edit the :type and save it again.',

        'draft'             => 'This is <b>' . trans('dynamic.draft') . '</b> ' . trans('dynamic.invoice') . ' and will be reflected to charts after it gets ' . trans('dynamic.sent') . '.',

        'status' => [
            'created'       => 'Created on :date',
            'viewed'        => 'Viewed',
            'send' => [
                'draft'     => trans('dynamic.draft'),
                'sent'      => trans('dynamic.sent_on', [ 'date' => ':date' ]),
                'sending'   => trans('dynamic.sending_now'),
            ],
            'paid' => [
                'await'     => 'Awaiting payment',
            ],
        ],

        'name_or_description_required' => 'Your invoice must show at least one of the <b>:name</b> or <b>:description</b>.',
    ],

    'share' => [
        'show_link'         => 'Your customer can view the invoice at this link',
        'copy_link'         => 'Copy the link and share it with your customer.',
        'success_message'   => 'Copied share link to clipboard!',
    ],

    'sticky' => [
        'description'       => 'You are previewing how your customer will see the web version of your invoice.',
    ],

];
