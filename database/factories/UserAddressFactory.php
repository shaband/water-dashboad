<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserAddress;

class UserAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'receiver_name' => $this->faker->word,
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'flat' => $this->faker->word,
            'user_id' => User::factory(),
            'notes' => $this->faker->text,
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
        ];
    }
}
