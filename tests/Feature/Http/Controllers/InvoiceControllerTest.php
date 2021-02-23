<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Agent;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InvoiceController
 */
class InvoiceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $invoices = Invoice::factory()->count(3)->create();

        $response = $this->get(route('invoice.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoice.show', $invoice));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InvoiceController::class,
            'update',
            \App\Http\Requests\InvoiceUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $invoice = Invoice::factory()->create();
        $agent = Agent::factory()->create();
        $user = User::factory()->create();
        $payment_type = $this->faker->word;
        $is_charity = $this->faker->randomDigitNotNull;
        $status = $this->faker->randomElement(/** enum_attributes **/);
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $delivery_price = $this->faker->randomFloat(/** decimal_attributes **/);
        $descount = $this->faker->randomFloat(/** decimal_attributes **/);
        $tax = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('invoice.update', $invoice), [
            'agent_id' => $agent->id,
            'user_id' => $user->id,
            'payment_type' => $payment_type,
            'is_charity' => $is_charity,
            'status' => $status,
            'price' => $price,
            'delivery_price' => $delivery_price,
            'descount' => $descount,
            'tax' => $tax,
        ]);

        $invoice->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($agent->id, $invoice->agent_id);
        $this->assertEquals($user->id, $invoice->user_id);
        $this->assertEquals($payment_type, $invoice->payment_type);
        $this->assertEquals($is_charity, $invoice->is_charity);
        $this->assertEquals($status, $invoice->status);
        $this->assertEquals($price, $invoice->price);
        $this->assertEquals($delivery_price, $invoice->delivery_price);
        $this->assertEquals($descount, $invoice->descount);
        $this->assertEquals($tax, $invoice->tax);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $invoice = Invoice::factory()->create();

        $response = $this->delete(route('invoice.destroy', $invoice));

        $response->assertNoContent();

        $this->assertDeleted($invoice);
    }
}
