<?php

namespace App\Models;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'email',
        'phone',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tokens(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(FcmToken::class, 'notifiable');
    }

    public function messages(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Message::class, 'sender');
    }


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    public function getRoleIdAttribute()
    {

        return $this->roles()->first()->id;
    }

    public function sendPasswordResetNotification($token)
    {

        ResetPasswordNotification::createUrlUsing(function ($notifiable, $token) {
            return url("admin/reset-password?email={$notifiable->email}&token=$token");
        });

        $this->notify(new ResetPasswordNotification($token));
    }

//
//    /**
//     * Send the password reset notification.
//     *
//     * @param  string  $token
//     * @return void
//     */
//    public function sendPasswordResetNotification($token)
//    {
//
//        $this->notify(new ResetPasswordNotification($token));
//    }

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->tokens()->pluck('token')->toArray();
    }

    /**
     * @param int $chat_id
     * @param array $msg
     * @return Message
     */
    public function sendMessage(int $chat_id, array $msg): Message
    {
        /** @var Message $message */
        $message = $this->messages()->create(
            [
                'chat_id' => $chat_id,
                'message' => $msg['message'],
                'file' => $msg['file'] ?? null,
                'file_ext' => isset($msg['file']) ? $this->getFileExt($msg['file']) : null,
            ])->load('sender');
        event(new \App\Events\MessageSent($message));
        return $message;
    }

    /**
     * @param $file
     * @return false|string
     */
    public function getFileExt($file)
    {
        return substr(strrchr($file, '.'), 1);
    }
}
