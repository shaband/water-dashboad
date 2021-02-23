<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Admin;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

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
            'image' => $this->faker->text,
            'remember_token' => $this->faker->word,
        ];
    }
}
