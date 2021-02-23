<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AddressController
 */
class AddressControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $addresses = Address::factory()->count(3)->create();

        $response = $this->get(route('address.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AddressController::class,
            'store',
            \App\Http\Requests\AddressStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $address = $this->faker->text;

        $response = $this->post(route('address.store'), [
            'address' => $address,
        ]);

        $addresses = Address::query()
            ->where('address', $address)
            ->get();
        $this->assertCount(1, $addresses);
        $address = $addresses->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $address = Address::factory()->create();

        $response = $this->get(route('address.show', $address));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AddressController::class,
            'update',
            \App\Http\Requests\AddressUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $address = Address::factory()->create();
        $address = $this->faker->text;

        $response = $this->put(route('address.update', $address), [
            'address' => $address,
        ]);

        $address->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($address, $address->address);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $address = Address::factory()->create();

        $response = $this->delete(route('address.destroy', $address));

        $response->assertNoContent();

        $this->assertDeleted($address);
    }
}
