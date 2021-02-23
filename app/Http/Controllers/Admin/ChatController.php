<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\MessageResource;
use App\Http\Requests\Admin\Chat\{ChatStoreRequest, ChatUpdateRequest};
use App\Http\Resources\Chat\ChatResource;
use App\Models\Chat;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return ChatResource::collection(Chat::query()
            ->ofUser(auth()->user())
            ->withCount(['unseen_messages'])
            ->with(['last_message', 'second', 'first'])
            ->paginate());
    }


    /**
     * @param ChatStoreRequest $request
     * @return MessageResource
     */
    public function store(ChatStoreRequest $request)
    {

        $chat = Chat::firstOrcreate(['id' => $request->id], $request->validated() + ['first_id' => auth()->id(), 'first_type' => 'admins']);
        $message = auth()->user()->sendMessage($chat->id, $request->msg);
        return new MessageResource($message->load('sender'));
    }


    /**
     * @param Request $request
     * @param Chat $chat
     * @return ChatResource
     */
    public function show(Request $request, $model_type, $model_id)
    {
        $model = Relation::morphMap()[$model_type];
        $user = $model::find($model_id);
        $chat = Chat::query()->with('messages', 'second', 'first')->betweenUsers(auth()->user(), $user)->first();
        if (is_null($chat)) {
            $chat = (new Chat([
                'first_type' => array_flip(Relation::morphMap())[get_class(auth()->user())],
                'second_type' => $model_type,
                'first_id' => auth()->id(),
                'second_id' => $model_id,
            ]))->load('messages', 'second', 'first');

        }
        return new ChatResource($chat);
    }


}
