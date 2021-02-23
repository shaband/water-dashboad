<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Agent;
use App\Models\City;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AgentController
 */
class AgentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $agents = Agent::factory()->count(3)->create();

        $response = $this->get(route('agent.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AgentController::class,
            'store',
            \App\Http\Requests\AgentStoreRequest::class
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
        $image = $this->faker->word;
        $city = City::factory()->create();

        $response = $this->post(route('agent.store'), [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'phone' => $phone,
            'image' => $image,
            'city_id' => $city->id,
        ]);

        $agents = Agent::query()
            ->where('name', $name)
            ->where('password', $password)
            ->where('email', $email)
            ->where('phone', $phone)
            ->where('image', $image)
            ->where('city_id', $city->id)
            ->get();
        $this->assertCount(1, $agents);
        $agent = $agents->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $agent = Agent::factory()->create();

        $response = $this->get(route('agent.show', $agent));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AgentController::class,
            'update',
            \App\Http\Requests\AgentUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $agent = Agent::factory()->create();
        $name = $this->faker->name;
        $password = $this->faker->password;
        $email = $this->faker->safeEmail;
        $phone = $this->faker->phoneNumber;
        $image = $this->faker->word;
        $city = City::factory()->create();

        $response = $this->put(route('agent.update', $agent), [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'phone' => $phone,
            'image' => $image,
            'city_id' => $city->id,
        ]);

        $agent->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $agent->name);
        $this->assertEquals($password, $agent->password);
        $this->assertEquals($email, $agent->email);
        $this->assertEquals($phone, $agent->phone);
        $this->assertEquals($image, $agent->image);
        $this->assertEquals($city->id, $agent->city_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $agent = Agent::factory()->create();

        $response = $this->delete(route('agent.destroy', $agent));

        $response->assertNoContent();

        $this->assertDeleted($agent);
    }
}
