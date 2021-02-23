<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CategoryController
 */
class CategoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $categories = Category::factory()->count(3)->create();

        $response = $this->get(route('category.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryController::class,
            'store',
            \App\Http\Requests\CategoryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->post(route('category.store'), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $categories = Category::query()
            ->where('name_ar', $name_ar)
            ->where('name_en', $name_en)
            ->get();
        $this->assertCount(1, $categories);
        $category = $categories->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('category.show', $category));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CategoryController::class,
            'update',
            \App\Http\Requests\CategoryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $category = Category::factory()->create();
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;

        $response = $this->put(route('category.update', $category), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
        ]);

        $category->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name_ar, $category->name_ar);
        $this->assertEquals($name_en, $category->name_en);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('category.destroy', $category));

        $response->assertNoContent();

        $this->assertDeleted($category);
    }
}
