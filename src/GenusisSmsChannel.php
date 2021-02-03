<?php

namespace Sykez\GenusisSms;

use Sykez\GenusisSms\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class GenusisSmsChannel
{
    protected $client;

    public function __construct(GenusisGensuiteClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\:channel_namespace\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        //$response = [a call to the api of your notification send]

//        if ($response->error) { // replace this by the code need to check for errors
//            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
//        }

        $message = $notification->toSms($notifiable);
        // dd($message);

        if (is_string($message)) {
            $message = new GenusisSmsMessage($message);
        }

        if ($to = $notifiable->routeNotificationFor('sms')) {
            // dd($to);
            $message->to($to);
        }

        return $this->client->send($message);
    }
}
