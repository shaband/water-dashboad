<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Chat;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_id' => $this->faker->randomDigitNotNull,
            'first_type' => $this->faker->word,
            'second_id' => $this->faker->randomDigitNotNull,
            'second_type' => $this->faker->word,
        ];
    }
}
