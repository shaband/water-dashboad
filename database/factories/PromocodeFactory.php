<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Promocode;

class PromocodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Promocode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'from_date' => $this->faker->dateTime(),
            'to_date' => $this->faker->dateTime(),
            'times' => $this->faker->numberBetween(-10000, 10000),
            'percent' => $this->faker->randomFloat(6, 0, 9999.999999),
        ];
    }
}
