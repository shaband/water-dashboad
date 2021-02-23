<?php

namespace App\Notifications;

use App\Http\Resources\Chat\MessageResource;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidMessagePriority;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;
use NotificationChannels\Fcm\Resources\FcmOptions;
use NotificationChannels\Fcm\Resources\NotificationPriority;
use NotificationChannels\Fcm\Resources\WebpushConfig;

class PushChatMessage extends Notification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $message;

    public function __construct(Message $message)

    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {

        $data = (new MessageResource($this->message))->jsonSerialize();
        $data['type'] = 'new_chat_message';

        $data['sender_image'] = $data['sender']['image'];
        unset($data['sender']);
        $data = array_map('strval', $data);
        /*$2y$10$o.dka5DxjLON/9Aqf.5J8Ox2f90QKv1QeSnOL.NBjrDFpK6uCNl7G*/
        return FcmMessage::create()
            ->setData($data)
            ->setFcmOptions(FcmOptions::create())
            ->setName('new_chat_message')
            ->setAndroid(
                $this->setAndroidConfig()
            )
            ->setApns(
                $this->setApnsConfig()
            );


    }

    /**
     * @return ApnsConfig
     */
    public function setApnsConfig(): ApnsConfig
    {
        return ApnsConfig::create()
            ->setFcmOptions(
                ApnsFcmOptions::create()->
                setAnalyticsLabel('analytics_ios')

            );
    }

    /**
     * @return AndroidConfig
     */
    public function setAndroidConfig(): AndroidConfig
    {
        return AndroidConfig::create()
            ->setFcmOptions(AndroidFcmOptions::create()
                ->setAnalyticsLabel('analytics')
            )
            ->setNotification(AndroidNotification::create()
                ->setNotificationPriority(NotificationPriority::PRIORITY_MAX()
                )
                ->setColor('# 0A0A0A')
            );
    }
}
