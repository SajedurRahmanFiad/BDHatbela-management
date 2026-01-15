<?php

use Tests\TestCase;
use App\Models\Document\Document;
use App\Models\Document\DocumentTotal;
use App\Jobs\Document\UpdateDocument;

class UpdatePreservesShippingTest extends TestCase
{
    /** @test */
    public function it_preserves_shipping_when_update_request_does_not_include_shipping()
    {
        $document = Document::factory()->create(['type' => Document::INVOICE_TYPE, 'currency_code' => 'USD']);

        // create an existing shipping total
        DocumentTotal::create([
            'company_id' => $document->company_id,
            'type' => $document->type,
            'document_id' => $document->id,
            'code' => 'shipping',
            'name' => 'invoices.shipping',
            'amount' => 15,
            'operator' => 'addition',
            'sort_order' => 1,
            'created_from' => 'unit-test',
            'created_by' => 1,
        ]);

        $this->assertDatabaseHas('document_totals', ['document_id' => $document->id, 'code' => 'shipping', 'amount' => 15]);

        // prepare an update request that does NOT include shipping or totals
        $request = [
            'company_id' => $document->company_id,
            'type' => $document->type,
            'created_from' => 'unit-test',
            'created_by' => 1,
            'items' => [],
            'currency_rate' => 1,
            'amount' => 0,
            // note: intentionally no 'shipping' or 'totals' keys
        ];

        $job = new UpdateDocument($document, $request);
        $job->handle();

        // shipping total should still exist after update
        $this->assertDatabaseHas('document_totals', ['document_id' => $document->id, 'code' => 'shipping', 'amount' => 15]);
    }
}
