<?php

namespace Tests\Feature;

use App\Models\Auth\User;
use App\Models\Common\Company;
use App\Models\Document\Document;
use App\Models\Setting\Currency;
use App\Models\Setting\Tax;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SteadfastCourierTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSendOrderToSteadfastCourier()
    {
        // Create a user and company
        $user = User::factory()->create();
        $company = Company::factory()->create();
        $this->be($user);

        // Create a customer
        $customer = User::factory()->create();

        // Create a currency
        Currency::factory()->create();

        // Create a tax
        Tax::factory()->create();

        // Create an invoice
        $invoice = Document::factory()->invoice()->create([
            'company_id' => $company->id,
            'contact_id' => $customer->id,
        ]);

        // Mock the SteadfastCourier facade
        \SteadFast\SteadFastCourierLaravelPackage\Facades\SteadfastCourier::shouldReceive('placeOrder')
            ->once()
            ->andReturn(['status' => 200, 'message' => 'Order placed successfully']);

        // Send a request to the send-order endpoint
        $response = $this->post(route('api.steadfast-courier.send-order'), [
            'invoice_id' => $invoice->id,
        ]);

        // Assert the response is successful
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Order sent to Steadfast Courier successfully',
        ]);
    }
}
