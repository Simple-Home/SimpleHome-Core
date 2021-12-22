<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeviceUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [
            'firebase' => FirebaseChannel::class,
        ];
        $parsedChannels = [];

        foreach ((array)$notifiable->notification_preferences as $channel) {
            if (in_array($channel, array_keys($channels))) {
                $parsedChannels[] = $channels[$channel];
            } else {
                $parsedChannels[] = $channel;
            }
        }

        return $parsedChannels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->line($this->device->hostname . ' vas updated to new version!');
    }

    public function toFirebase($notifiable)
    {
        return [
            'title' => $this->device->hostname,
            'body' => 'vas updated to new version',
            "icon" => "https:" . env('APP_URL') . '/favicon.ico',
        ];
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->device->hostname,
            'message' => 'vas updated to new version',
            'type' => 'info'
        ];
    }
}
