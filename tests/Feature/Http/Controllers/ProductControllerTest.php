<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Mark;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ProductController
 */
class ProductControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $products = Product::factory()->count(3)->create();

        $response = $this->get(route('product.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'store',
            \App\Http\Requests\ProductStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;
        $mark = Mark::factory()->create();
        $category = Category::factory()->create();
        $is_charity = $this->faker->boolean;

        $response = $this->post(route('product.store'), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
            'mark_id' => $mark->id,
            'category_id' => $category->id,
            'is_charity' => $is_charity,
        ]);

        $products = Product::query()
            ->where('name_ar', $name_ar)
            ->where('name_en', $name_en)
            ->where('mark_id', $mark->id)
            ->where('category_id', $category->id)
            ->where('is_charity', $is_charity)
            ->get();
        $this->assertCount(1, $products);
        $product = $products->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('product.show', $product));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ProductController::class,
            'update',
            \App\Http\Requests\ProductUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $product = Product::factory()->create();
        $name_ar = $this->faker->word;
        $name_en = $this->faker->word;
        $mark = Mark::factory()->create();
        $category = Category::factory()->create();
        $is_charity = $this->faker->boolean;

        $response = $this->put(route('product.update', $product), [
            'name_ar' => $name_ar,
            'name_en' => $name_en,
            'mark_id' => $mark->id,
            'category_id' => $category->id,
            'is_charity' => $is_charity,
        ]);

        $product->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name_ar, $product->name_ar);
        $this->assertEquals($name_en, $product->name_en);
        $this->assertEquals($mark->id, $product->mark_id);
        $this->assertEquals($category->id, $product->category_id);
        $this->assertEquals($is_charity, $product->is_charity);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('product.destroy', $product));

        $response->assertNoContent();

        $this->assertDeleted($product);
    }
}
