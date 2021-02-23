<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\AgentProduct;
use App\Models\Product;

class AgentProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AgentProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->randomFloat(0, 0, 999),
            'quantity' => $this->faker->numberBetween(-100000, 100000),
            'product_id' => Product::factory(),
            'agent_id' => Agent::factory(),
        ];
    }
}
