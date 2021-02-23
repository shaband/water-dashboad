<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CarType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarTypeController
 */
class CarTypeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $carTypes = CarType::factory()->count(3)->create();

        $response = $this->get(route('car-type.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CarTypeController::class,
            'store',
            \App\Http\Requests\CarTypeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->post(route('car-type.store'), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $carTypes = CarType::query()
            ->where('name_ar', $name_ar)
            ->where('name_en', $name_en)
            ->get();
        $this->assertCount(1, $carTypes);
        $carType = $carTypes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $carType = CarType::factory()->create();

        $response = $this->get(route('car-type.show', $carType));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CarTypeController::class,
            'update',
            \App\Http\Requests\CarTypeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $carType = CarType::factory()->create();
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->put(route('car-type.update', $carType), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $carType->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name_ar, $carType->name_ar);
        $this->assertEquals($name_en, $carType->name_en);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $carType = CarType::factory()->create();

        $response = $this->delete(route('car-type.destroy', $carType));

        $response->assertNoContent();

        $this->assertDeleted($carType);
    }
}
