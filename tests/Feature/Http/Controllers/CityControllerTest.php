<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CityController
 */
class CityControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $cities = City::factory()->count(3)->create();

        $response = $this->get(route('city.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CityController::class,
            'store',
            \App\Http\Requests\CityStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->post(route('city.store'), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $cities = City::query()
            ->where('name_ar', $name_ar)
            ->where('name_en', $name_en)
            ->get();
        $this->assertCount(1, $cities);
        $city = $cities->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $city = City::factory()->create();

        $response = $this->get(route('city.show', $city));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CityController::class,
            'update',
            \App\Http\Requests\CityUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $city = City::factory()->create();
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->put(route('city.update', $city), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $city->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name_ar, $city->name_ar);
        $this->assertEquals($name_en, $city->name_en);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $city = City::factory()->create();

        $response = $this->delete(route('city.destroy', $city));

        $response->assertNoContent();

        $this->assertDeleted($city);
    }
}
