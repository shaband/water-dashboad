<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CarType;
use App\Models\Delivery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DeliveryController
 */
class DeliveryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $deliveries = Delivery::factory()->count(3)->create();

        $response = $this->get(route('delivery.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeliveryController::class,
            'store',
            \App\Http\Requests\DeliveryStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $name = $this->faker->name;
        $password = $this->faker->password;
        $email = $this->faker->safeEmail;
        $phone = $this->faker->phoneNumber;
        $image = $this->faker->text;
        $car_number = $this->faker->word;
        $car_Paper_image = $this->faker->word;
        $car_type = CarType::factory()->create();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->post(route('delivery.store'), [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'phone' => $phone,
            'image' => $image,
            'car_number' => $car_number,
            'car_Paper_image' => $car_Paper_image,
            'car_type_id' => $car_type->id,
            'status' => $status,
        ]);

        $deliveries = Delivery::query()
            ->where('name', $name)
            ->where('password', $password)
            ->where('email', $email)
            ->where('phone', $phone)
            ->where('image', $image)
            ->where('car_number', $car_number)
            ->where('car_Paper_image', $car_Paper_image)
            ->where('car_type_id', $car_type->id)
            ->where('status', $status)
            ->get();
        $this->assertCount(1, $deliveries);
        $delivery = $deliveries->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $delivery = Delivery::factory()->create();

        $response = $this->get(route('delivery.show', $delivery));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeliveryController::class,
            'update',
            \App\Http\Requests\DeliveryUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $delivery = Delivery::factory()->create();
        $name = $this->faker->name;
        $password = $this->faker->password;
        $email = $this->faker->safeEmail;
        $phone = $this->faker->phoneNumber;
        $image = $this->faker->text;
        $car_number = $this->faker->word;
        $car_Paper_image = $this->faker->word;
        $car_type = CarType::factory()->create();
        $status = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('delivery.update', $delivery), [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'phone' => $phone,
            'image' => $image,
            'car_number' => $car_number,
            'car_Paper_image' => $car_Paper_image,
            'car_type_id' => $car_type->id,
            'status' => $status,
        ]);

        $delivery->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $delivery->name);
        $this->assertEquals($password, $delivery->password);
        $this->assertEquals($email, $delivery->email);
        $this->assertEquals($phone, $delivery->phone);
        $this->assertEquals($image, $delivery->image);
        $this->assertEquals($car_number, $delivery->car_number);
        $this->assertEquals($car_Paper_image, $delivery->car_Paper_image);
        $this->assertEquals($car_type->id, $delivery->car_type_id);
        $this->assertEquals($status, $delivery->status);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $delivery = Delivery::factory()->create();

        $response = $this->delete(route('delivery.destroy', $delivery));

        $response->assertNoContent();

        $this->assertDeleted($delivery);
    }
}
