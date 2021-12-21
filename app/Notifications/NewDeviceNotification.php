<?php

namespace App\Notifications;

use App\Models\Devices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $device;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Devices $device)
    {
        $this->device = $device;
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

        foreach ((array)$notifiable->notifications_preferencies as $channel) {
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
        return (new MailMessage)
            ->line('New Device was detected!')
            ->action('Approve', url('/'));
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
            'title' => 'New Device Detected!',
            'message' => 'New device type ' . $this->device->type . ' with token ' . $this->device->token . ' was detected. Device is providet by integration: ' . $this->device->integration,
            'type' => 'info'
        ];
    }
}
