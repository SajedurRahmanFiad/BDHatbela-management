<?php

use Tests\TestCase;
use App\Models\Document\Document;
use App\Jobs\Document\CreateDocumentItemsAndTotals;

class CreateDocumentShippingTest extends TestCase
{
    /** @test */
    public function it_creates_shipping_document_total_when_shipping_is_set()
    {
        // minimal setup: create a document and run job
        $document = Document::factory()->create(['type' => Document::INVOICE_TYPE, 'currency_code' => 'USD']);

        $request = [
            'company_id' => $document->company_id,
            'type' => $document->type,
            'document_id' => $document->id,
            'created_from' => 'unit-test',
            'created_by' => 1,
            'items' => [],
            'totals' => [
                ['code' => 'shipping', 'name' => 'invoices.shipping', 'amount' => 10, 'operator' => 'addition']
            ],
            'currency_rate' => 1,
            'amount' => 0,
        ];

        $job = new CreateDocumentItemsAndTotals($document, $request);
        $job->handle();

        $this->assertDatabaseHas('document_totals', ['document_id' => $document->id, 'code' => 'shipping', 'amount' => 10]);
        $this->assertDatabaseHas('documents', ['id' => $document->id, 'shipping' => 10]);
    }

    /** @test */
    public function it_creates_shipping_document_total_when_shipping_param_set()
    {
        $document = Document::factory()->create(['type' => Document::INVOICE_TYPE, 'currency_code' => 'USD']);

        $request = [
            'company_id' => $document->company_id,
            'type' => $document->type,
            'document_id' => $document->id,
            'created_from' => 'unit-test',
            'created_by' => 1,
            'items' => [],
            'currency_rate' => 1,
            'amount' => 0,
            'shipping' => 10,
        ];

        $job = new CreateDocumentItemsAndTotals($document, $request);
        $job->handle();

        $this->assertDatabaseHas('document_totals', ['document_id' => $document->id, 'code' => 'shipping', 'amount' => 10]);
        $this->assertDatabaseHas('documents', ['id' => $document->id, 'shipping' => 10]);
    }
}

