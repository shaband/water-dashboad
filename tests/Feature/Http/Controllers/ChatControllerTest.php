<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Chat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ChatController
 */
class ChatControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_behaves_as_expected()
    {
        $chats = Chat::factory()->count(3)->create();

        $response = $this->get(route('chat.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChatController::class,
            'store',
            \App\Http\Requests\ChatStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $response = $this->post(route('chat.store'));

        $response->assertCreated();
        $response->assertJsonStructure([]);

        $this->assertDatabaseHas(chats, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_behaves_as_expected()
    {
        $chat = Chat::factory()->create();

        $response = $this->get(route('chat.show', $chat));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ChatController::class,
            'update',
            \App\Http\Requests\ChatUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_behaves_as_expected()
    {
        $chat = Chat::factory()->create();

        $response = $this->put(route('chat.update', $chat));

        $chat->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_responds_with()
    {
        $chat = Chat::factory()->create();

        $response = $this->delete(route('chat.destroy', $chat));

        $response->assertNoContent();

        $this->assertDeleted($chat);
    }
}
