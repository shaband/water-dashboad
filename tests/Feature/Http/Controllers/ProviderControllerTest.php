<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProviderController
 */
class ProviderControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $providers = Provider::factory()->count(3)->create();

        $response = $this->get(route('provider.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProviderController::class,
            'store',
            \App\Http\Requests\ProviderStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->post(route('provider.store'), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $providers = Provider::query()
            ->where('name_ar', $name_ar)
            ->where('name_en', $name_en)
            ->get();
        $this->assertCount(1, $providers);
        $provider = $providers->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $provider = Provider::factory()->create();

        $response = $this->get(route('provider.show', $provider));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProviderController::class,
            'update',
            \App\Http\Requests\ProviderUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $provider = Provider::factory()->create();
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->put(route('provider.update', $provider), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $provider->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name_ar, $provider->name_ar);
        $this->assertEquals($name_en, $provider->name_en);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $provider = Provider::factory()->create();

        $response = $this->delete(route('provider.destroy', $provider));

        $response->assertNoContent();

        $this->assertDeleted($provider);
    }
}
