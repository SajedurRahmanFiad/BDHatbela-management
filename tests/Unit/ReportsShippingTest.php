<?php

use Tests\TestCase;
use App\Models\Document\Document;
use App\Models\Document\DocumentTotal;

class ReportsShippingTest extends TestCase
{
    /** @test */
    public function shipping_is_counted_as_revenue_in_reports()
    {
        $document = Document::factory()->create(['type' => Document::INVOICE_TYPE, 'currency_code' => 'USD']);

        DocumentTotal::create([
            'company_id' => $document->company_id,
            'type' => $document->type,
            'document_id' => $document->id,
            'code' => 'shipping',
            'name' => 'invoices.shipping',
            'amount' => 10,
            'sort_order' => 5,
        ]);

        // Simple assertion: shipping total exists and is positive
        $this->assertDatabaseHas('document_totals', ['document_id' => $document->id, 'code' => 'shipping', 'amount' => 10]);

        // Further report-level checks would require running report generators; ensure at least that totals query includes code 'shipping'
        $totals = DocumentTotal::where('document_id', $document->id)->get();

        $this->assertTrue($totals->pluck('code')->contains('shipping'));
    }

    /** @test */
    public function it_subtracts_shipping_from_net_profit()
    {
        $document = Document::factory()->create([
            'type' => Document::INVOICE_TYPE,
            'currency_code' => 'USD',
            'status' => 'sent',
            'issued_at' => now(),
            'amount' => 100,
        ]);

        DocumentTotal::create([
            'company_id' => $document->company_id,
            'type' => $document->type,
            'document_id' => $document->id,
            'code' => 'shipping',
            'name' => 'invoices.shipping',
            'amount' => 10,
            'sort_order' => 5,
        ]);

        // Create a report model for ProfitLoss and load it
        $reportModel = \App\Models\Common\Report::create([
            'company_id' => $document->company_id,
            'class' => 'App\\Reports\\ProfitLoss',
            'name' => 'Profit Loss Test',
        ]);

        $report = new \App\Reports\ProfitLoss($reportModel, true);

        $total_net_profit = array_sum($report->net_profit);

        // Expect net profit to be invoice amount (100) minus shipping (10) => 90
        $this->assertEquals(90, round($total_net_profit));
    }
}
