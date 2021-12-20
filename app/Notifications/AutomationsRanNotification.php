<?php

namespace App\Notifications;

use App\Models\Automations;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AutomationsRanNotification extends Notification
{
    use Queueable;
    protected $automation;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Automations $automation)
    {
        $this->automation = $automation;
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

        foreach ($notifiable->notifications_preferencies as $channel) {
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
            ->line('Automation ran!');
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
            'title' => 'Automation!',
            'message' => 'Ran ' . $this->automation->name . " at " . $this->automation->run_at,
            'type' => 'info'
        ];
    }
}
