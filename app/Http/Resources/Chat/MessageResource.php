<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MessageResource
 * @package App\Http\Resources\Chat
 * @mixin \App\Models\Message
 */
class MessageResource extends JsonResource
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
            'chat_id' => $this->chat_id,
            'message' => $this->message,
            'sender' => $this->getSender(),
            'is_sender' => $this->is_sender,
            'file' => \Str::startsWith($this->file, ['http://', 'https://']) ? $this->file : \Storage::url($this->file),
            'file_ext' => $this->file_ext,
            'seen_at' => optional($this->seen_at)->format('Y-m-d h:m A'),
            'date' => optional($this->created_at)->format('Y-m-d h:m A'),
            'time' => optional($this->created_at)->toTimeString(),
        ];
    }

    /**
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    public function getSender()
    {
        return $this->when($this->relationLoaded('sender'), function () {
            return [
                'id' => $this->sender->id,
                'name' => $this->sender->name,
                'image' => $this->sender->image,
            ];
        });
    }
}
