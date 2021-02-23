<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Mark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MarkController
 */
class MarkControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $marks = Mark::factory()->count(3)->create();

        $response = $this->get(route('mark.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MarkController::class,
            'store',
            \App\Http\Requests\MarkStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->post(route('mark.store'), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $marks = Mark::query()
            ->where('name_ar', $name_ar)
            ->where('name_en', $name_en)
            ->get();
        $this->assertCount(1, $marks);
        $mark = $marks->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $mark = Mark::factory()->create();

        $response = $this->get(route('mark.show', $mark));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MarkController::class,
            'update',
            \App\Http\Requests\MarkUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $mark = Mark::factory()->create();
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->put(route('mark.update', $mark), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $mark->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name_ar, $mark->name_ar);
        $this->assertEquals($name_en, $mark->name_en);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $mark = Mark::factory()->create();

        $response = $this->delete(route('mark.destroy', $mark));

        $response->assertNoContent();

        $this->assertDeleted($mark);
    }
}
