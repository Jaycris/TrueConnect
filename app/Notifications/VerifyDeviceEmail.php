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
    public $fullName;

    /**
     * Create a new notification instance.
     *
     * @param string $code
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($code, $fullName)
    {
        $this->code = $code;
        $this->fullName = $fullName;
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
        //\Log::info('Sending 2FA email with code: ' . $this->code);
        return (new MailMessage)
                    ->subject('Your login verification code')
                    ->greeting('Hello!')
                    ->line('A new device has been detected logging in to ' . $this->fullName . ' account.')                    
                    ->line('Your Verification code is: ' . $this->code)
                    ->line('This code will expire in 10 minutes.')
                    ->line('Thank you!')
                    ->salutation('Regards,  ' . PHP_EOL . 'Page Chronicles Team');
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
