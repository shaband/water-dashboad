<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'chat_id',
        'sender',
        'file',
        'file_ext',
        'seen_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'chat_id' => 'integer',
        'seen_at' => 'timestamp',
    ];


    public function chat()
    {
        return $this->belongsTo(\App\Models\Chat::class);
    }

    public function sender(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('sender');
    }

    public function getReceiverAttribute()
    {
        /** @var Chat $chat */
        $chat = $this->chat;
        if (
            $chat->first_id == $this->sender_id
            &&
            $chat->first_model != $this->sender_type
        ) {
            return $chat->second;
        }
        return $chat->first;

    }

    public function getIsSenderAttribute(): bool
    {
        $morphs = array_flip(Relation::morphMap());
        if (auth()->check()) {
            return (
                $this->sender_id == auth()->id()
                &&
                $this->sender_model != $morphs[get_class(auth()->user())]
            );
        }
        return false;
    }
}
