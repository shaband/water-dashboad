<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminController
 */
class AdminControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $admins = Admin::factory()->count(3)->create();

        $response = $this->get(route('admin.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminController::class,
            'store',
            \App\Http\Requests\AdminStoreRequest::class
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

        $response = $this->post(route('admin.store'), [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'phone' => $phone,
        ]);

        $admins = Admin::query()
            ->where('name', $name)
            ->where('password', $password)
            ->where('email', $email)
            ->where('phone', $phone)
            ->get();
        $this->assertCount(1, $admins);
        $admin = $admins->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $admin = Admin::factory()->create();

        $response = $this->get(route('admin.show', $admin));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminController::class,
            'update',
            \App\Http\Requests\AdminUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $admin = Admin::factory()->create();
        $name = $this->faker->name;
        $password = $this->faker->password;
        $email = $this->faker->safeEmail;
        $phone = $this->faker->phoneNumber;

        $response = $this->put(route('admin.update', $admin), [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'phone' => $phone,
        ]);

        $admin->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $admin->name);
        $this->assertEquals($password, $admin->password);
        $this->assertEquals($email, $admin->email);
        $this->assertEquals($phone, $admin->phone);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $admin = Admin::factory()->create();

        $response = $this->delete(route('admin.destroy', $admin));

        $response->assertNoContent();

        $this->assertDeleted($admin);
    }
}
