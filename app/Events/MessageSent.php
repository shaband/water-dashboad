<?php

namespace App\Events;

use App\Models\Admin;
use App\Models\Message;
use App\Notifications\PushChatMessage;
use Illuminate\Queue\SerializesModels;

class MessageSent
{
    use SerializesModels;

    public $message;


    /**
     * Create a new event instance.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        /** @var Admin $receiver */
        $receiver = $this->message->receiver;
        $receiver->notify(new PushChatMessage($this->message));
    }
}
