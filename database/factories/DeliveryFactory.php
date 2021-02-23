<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CarType;
use App\Models\City;
use App\Models\Delivery;

class DeliveryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Delivery::class;

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
            'car_number' => $this->faker->word,
            'car_Paper_image' => $this->faker->word,
            'car_type_id' => CarType::factory(),
            'city_id' => City::factory(),
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
            'blocked_at' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(["pending","accepted","refused"]),
        ];
    }
}
