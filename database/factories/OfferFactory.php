<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\AgentProduct;
use App\Models\Offer;
use App\Models\Product;

class OfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'precent' => $this->faker->text,
            'price' => $this->faker->randomFloat(0, 0, 9),
            'agent_id' => Agent::factory(),
            'agent_product_id' => AgentProduct::factory(),
            'quantity' => $this->faker->numberBetween(-10000, 10000),
            'start_at' => $this->faker->dateTime(),
            'finish_at' => $this->faker->dateTime(),
        ];
    }
}
