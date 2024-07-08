<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeviceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $deviceInfo;

    /**
     * Create a new notification instance.
     */
    public function __construct($deviceInfo)
    {
        $this->deviceInfo = $deviceInfo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Device Notification')
                    ->greeting('Hello!')
                    ->line('A new device has been detected logging into your account.')
                    ->line("Device Info: {$this->deviceInfo}")
                    ->action('View Account Activity', route('account.activity'))
                    ->line('If you did not authorize this login, please contact our support team immediately.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
