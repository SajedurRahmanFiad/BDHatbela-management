<?php

use Tests\TestCase;

class InvoiceListTest extends TestCase
{
    /** @test */
    public function invoice_list_shows_created_by_column_and_owner_name()
    {
        $owner = (object) ['name' => 'Alice Creator'];
        $doc = (object) [
            'id' => 1,
            'due_at' => null,
            'issued_at' => null,
            'status' => 'draft',
            'contact_name' => 'Customer',
            'document_number' => 'INV-1',
            'amount' => 100,
            'currency_code' => 'USD',
            'paid' => false,
            'owner' => $owner,
        ];

        $view = $this->view('components.documents.index.document', [
            'type' => 'invoice',
            'documents' => collect([$doc]),
            'hideBulkAction' => true,
            'hideDueAt' => true,
            'hideIssuedAt' => true,
            'hideStatus' => true,
            'hideContactName' => false,
            'hideDocumentNumber' => false,
            'hideAmount' => true,
            'showRoute' => 'invoices.show'
        ]);

        $html = $view->render();

        $this->assertStringContainsString('Created by', $html);
        $this->assertStringContainsString('Alice Creator', $html);
        // Should show full name as title and use a reasonable width/truncate class
        $this->assertStringContainsString('title="Alice Creator"', $html);
        $this->assertStringContainsString('w-48', $html);
    }
}
