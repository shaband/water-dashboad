<?php

namespace Tests\Feature\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MessageController
 */
class MessageControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MessageController::class,
            'store',
            \App\Http\Requests\MessageStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves()
    {
        $chat = Chat::factory()->create();
        $sender = $this->faker->;

        Event::fake();

        $response = $this->post(route('message.store'), [
            'chat_id' => $chat->id,
            'sender' => $sender,
        ]);

        $messages = Message::query()
            ->where('chat_id', $chat->id)
            ->where('sender', $sender)
            ->get();
        $this->assertCount(1, $messages);
        $message = $messages->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);

        Event::assertDispatched(MessageSent::class, function ($event) use ($message) {
            return $event->message->is($message);
        });
    }
}
