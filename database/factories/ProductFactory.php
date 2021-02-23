<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Mark;
use App\Models\Product;
use App\Models\Provider;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_ar' => $this->faker->word,
            'name_en' => $this->faker->word,
            'description_ar' => $this->faker->text,
            'description_en' => $this->faker->text,
            'mark_id' => Mark::factory()->create(),
            'category_id' => Category::factory()->create(),
            'provider_id' => Provider::factory()->create(),
            'is_charity' => $this->faker->boolean,
            'image' => $this->faker->image(),
        ];
    }
}
