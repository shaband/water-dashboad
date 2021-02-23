<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\NewPromocode;
use App\Models\Promocode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PromocodeController
 */
class PromocodeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $promocodes = Promocode::factory()->count(3)->create();

        $response = $this->get(route('promocode.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromocodeController::class,
            'store',
            \App\Http\Requests\PromocodeStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $code = $this->faker->word;
        $times = $this->faker->numberBetween(-10000, 10000);
        $percent = $this->faker->randomFloat(/** decimal_attributes **/);

        Event::fake();

        $response = $this->post(route('promocode.store'), [
            'code' => $code,
            'times' => $times,
            'percent' => $percent,
        ]);

        $promocodes = Promocode::query()
            ->where('code', $code)
            ->where('times', $times)
            ->where('percent', $percent)
            ->get();
        $this->assertCount(1, $promocodes);
        $promocode = $promocodes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);

        Event::assertDispatched(NewPromocode::class, function ($event) use ($promocode) {
            return $event->promocode->is($promocode);
        });
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $promocode = Promocode::factory()->create();

        $response = $this->get(route('promocode.show', $promocode));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromocodeController::class,
            'update',
            \App\Http\Requests\PromocodeUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $promocode = Promocode::factory()->create();
        $code = $this->faker->word;
        $times = $this->faker->numberBetween(-10000, 10000);
        $percent = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('promocode.update', $promocode), [
            'code' => $code,
            'times' => $times,
            'percent' => $percent,
        ]);

        $promocode->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($code, $promocode->code);
        $this->assertEquals($times, $promocode->times);
        $this->assertEquals($percent, $promocode->percent);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $promocode = Promocode::factory()->create();

        $response = $this->delete(route('promocode.destroy', $promocode));

        $response->assertNoContent();

        $this->assertDeleted($promocode);
    }
}
