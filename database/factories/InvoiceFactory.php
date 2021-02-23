<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Agent;
use App\Models\Delivery;
use App\Models\Invoice;
use App\Models\Promocode;
use App\Models\User;
use App\Models\UserAddress;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->word,
            'agent_id' => Agent::factory(),
            'user_id' => User::factory(),
            'address_id' => Address::factory(),
            'delivering_date' => $this->faker->date(),
            'delivering_time' => $this->faker->time(),
            'user_address_id' => UserAddress::factory(),
            'delivery_id' => Delivery::factory(),
            'agent_accepted_at' => $this->faker->dateTime(),
            'delivery_accepted_at' => $this->faker->dateTime(),
            'canceled_by' => $this->faker->randomElement(["agent","delivery","user"]),
            'canceled_at' => $this->faker->dateTime(),
            'payment_type' => $this->faker->word,
            'promocode_id' => Promocode::factory(),
            'is_charity' => $this->faker->randomDigitNotNull,
            'status' => $this->faker->randomElement(["new","delivery_approval","delivering","finished","canceled"]),
            'notes' => $this->faker->text,
            'price' => $this->faker->randomFloat(6, 0, 9999.999999),
            'delivery_price' => $this->faker->randomFloat(6, 0, 9999.999999),
            'discount' => $this->faker->randomFloat(6, 0, 9999.999999),
            'tax' => $this->faker->randomFloat(6, 0, 9999.999999),
            'lat' => $this->faker->latitude,
            'lng' => $this->faker->longitude,
        ];
    }
}
