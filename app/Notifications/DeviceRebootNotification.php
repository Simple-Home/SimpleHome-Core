<?php

namespace App\Notifications;

use App\Models\Devices;
use App\Notifications\Channels\FirebaseChannel;
use App\Notifications\Messages\FirebaseMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeviceRebootNotification extends Notification implements ShouldQueue
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
        return (new MailMessage)->line($this->device->hostname . ' was rebooted!');
    }

    public function toFirebase($notifiable)
    {
        return [
            'title' => $this->device->hostname . ' was rebooted!',
            'body' => 'Device is providet by integration: ' . $this->device->integration,
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
            'title' => $this->device->hostname . ' was rebooted!',
            'message' => 'Device is providet by integration: ' . $this->device->integration,
            'type' => 'info'
        ];
    }
}
