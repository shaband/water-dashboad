<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\FcmToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FcmTokenController
 */
class FcmTokenControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $fcmToken = FcmToken::factory()->create();

        $response = $this->delete(route('fcm-token.destroy', $fcmToken));

        $response->assertNoContent();

        $this->assertDeleted($fcmToken);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\FcmTokenController::class,
            'store',
            \App\Http\Requests\FcmTokenStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $token = $this->faker->text;
        $device = $this->faker->randomElement(/** enum_attributes **/);
        $notifiable = $this->faker->;

        $response = $this->post(route('fcm-token.store'), [
            'token' => $token,
            'device' => $device,
            'notifiable' => $notifiable,
        ]);

        $fcmTokens = FcmToken::query()
            ->where('token', $token)
            ->where('device', $device)
            ->where('notifiable', $notifiable)
            ->get();
        $this->assertCount(1, $fcmTokens);
        $fcmToken = $fcmTokens->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }
}
