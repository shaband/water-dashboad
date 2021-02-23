<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SettingController
 */
class SettingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $settings = Setting::factory()->count(3)->create();

        $response = $this->get(route('setting.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $setting = Setting::factory()->create();

        $response = $this->get(route('setting.show', $setting));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SettingController::class,
            'update',
            \App\Http\Requests\SettingUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $setting = Setting::factory()->create();
        $name = $this->faker->name;
        $type = $this->faker->randomElement(/** enum_attributes **/);

        $response = $this->put(route('setting.update', $setting), [
            'name' => $name,
            'type' => $type,
        ]);

        $setting->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($name, $setting->name);
        $this->assertEquals($type, $setting->type);
    }
}
