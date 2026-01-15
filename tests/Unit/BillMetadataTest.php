<?php

use Tests\TestCase;

class BillMetadataTest extends TestCase
{
    /** @test */
    public function bill_creation_uses_order_date_and_hides_due_and_bill_number()
    {
        $view = $this->view('components.documents.form.metadata', [
            'type' => 'bill',
            'issuedAt' => '2025-12-24',
            'documentNumber' => 'BILL-100',
            'dueAt' => '2025-12-24',
            'periodDueAt' => null,
            'orderNumber' => 'ORD-100',
            'hideIssuedAt' => false,
            'hideDocumentNumber' => false,
            'hideDueAt' => false,
            'hideOrderNumber' => false,
            'textContact' => 'general.contact',
            'typeContact' => 'contact',
            'contact' => null,
            'contacts' => [],
            'searchContactRoute' => null,
            'createContactRoute' => null,
            'textAddContact' => 'contacts.add',
            'textCreateNewContact' => 'contacts.create',
            'textEditContact' => 'contacts.edit',
            'textContactInfo' => 'contacts.info',
            'textChooseDifferentContact' => 'contacts.choose',
            'textIssuedAt' => 'bills.order_date',
            'textDocumentNumber' => 'bills.bill_number',
            'textDueAt' => 'bills.due_date',
            'textOrderNumber' => 'invoices.order_number'
        ]);

        $html = $view->render();

        // Hidden due_at should be present
        $this->assertStringContainsString('name="due_at"', $html);

        // Document number should be hidden (no visible input label for bill number)
        $this->assertStringNotContainsString(trans('bills.bill_number'), $html);
        $this->assertStringContainsString('name="document_number"', $html);

        // IssuedAt label should be Order Date
        $this->assertStringContainsString(trans('bills.order_date'), $html);
    }
}
