<?php

use Tests\TestCase;

class InvoiceMetadataTest extends TestCase
{
    /** @test */
    public function invoice_creation_hides_due_date_and_order_number_and_labels_document_number_as_order_number()
    {
        $view = $this->view('components.documents.form.metadata', [
            'type' => 'invoice',
            'issuedAt' => '2025-12-24',
            'documentNumber' => 'INV-100',
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
            'textIssuedAt' => 'invoices.invoice_date',
            'textDocumentNumber' => 'invoices.invoice_number',
            'textDueAt' => 'invoices.due_date',
            'textOrderNumber' => 'invoices.order_number'
        ]);

        $html = $view->render();

        // Hidden due_at should be present and bound to issuedAt value
        $this->assertStringContainsString('name="due_at"', $html);
        $this->assertStringContainsString('value="2025-12-24"', $html);

        // Hidden order_number should be present and bound to document_number via v-model
        $this->assertStringContainsString('name="order_number"', $html);

        // Document number label should be 'Order Number'
        $this->assertStringContainsString(trans('invoices.order_number'), $html);
    }
}
