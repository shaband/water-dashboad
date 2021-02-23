<?php

namespace App\Http\Resources\Chat;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ChatResource
 * @package App\Http\Resources\Chat
 * @mixin  \App\Models\Chat
 */
class ChatResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'other_user' => $this->getOtherUser(),
            'last_message' => new MessageResource($this->last_message),
            'unseen_messages' => $this->unseen_messages_count,
            'messages' => MessageResource::collection($this->whenLoaded('messages')),
        ];
    }

    /**
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    public function getOtherUser()
    {

        return $this->when($this->relationLoaded('first') && $this->relationLoaded('second'), function () {
            $morphs = array_flip(Relation::morphMap());

            return [
                'id' => $this->other_user->id,
                'name' => $this->other_user->name,
                'image' => \Str::startsWith($this->other_user->image, ['http://', 'https://']) ? $this->other_user->image : \Storage::url($this->other_user->image),
                'type' => $morphs[get_class($this->other_user)]
            ];
        });
    }
}
