<?php

namespace Sykez\GenusisSms;

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
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        if (is_string($message)) {
            $message = new GenusisSmsMessage($message);
        }

        if ($to = $notifiable->routeNotificationFor('sms')) {
            $message->to($to);
        }

        return $this->client->send($message);
    }
}
