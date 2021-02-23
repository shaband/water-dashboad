<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Offer;
use App\Models\Product;

class InvoiceProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' => Invoice::factory(),
            'product_id' => Product::factory(),
            'unit_price' => $this->faker->randomFloat(6, 0, 9999.999999),
            'quantity' => $this->faker->randomNumber(),
            'total_price' => $this->faker->randomFloat(6, 0, 9999.999999),
            'offer_id' => Offer::factory(),
        ];
    }
}
