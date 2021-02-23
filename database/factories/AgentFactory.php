<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Agent;
use App\Models\City;

class AgentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Agent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'password' => $this->faker->password,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'image' => $this->faker->word,
            'blocked_at' => $this->faker->dateTime(),
            'city_id' => City::factory(),
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
        ];
    }
}
