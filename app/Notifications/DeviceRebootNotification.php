<?php

namespace App\Notifications;

use App\Models\Devices;
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
        return ['database', 'mail'];
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
