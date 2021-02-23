<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\Admin\Chat\MessageStoreRequest;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * @param MessageStoreRequest $request
     * @return MessageResource
     */
    public function store(MessageStoreRequest $request)
    {
        $message = auth()->user()->sendMessage($request->chat_id, $request->all());;

//        event(new MessageSent($message));

        return new MessageResource($message);
    }
}
