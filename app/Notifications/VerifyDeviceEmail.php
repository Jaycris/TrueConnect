<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyDeviceEmail extends Notification implements ShouldQueue
{
    use Queueable;
    public $code;

    /**
     * Create a new notification instance.
     *
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Your login verification code')
                    ->greeting('Hello!')
                    ->line('A new device has been detected logging into your account.')
                    ->line('Your Verification code is: ' . $this->code)
                    ->line('This code will expire in 10 minutes.')
                    ->line('Thank you!')
                    ->salutation('Regards,  ' . PHP_EOL . 'Bookmarc Alliance Team');
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
