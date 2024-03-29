<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NextApps\VerificationCode\Notifications\VerificationCodeCreatedInterface;

class VerificationCodeCreated extends Notification implements ShouldQueue, VerificationCodeCreatedInterface
{
    use Queueable;

    /**
     * @var string
     */
    public $code;

    /**
     * Create a new message instance.
     *
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage())
            ->subject(__('email.your_verification_code'))
            ->markdown('email.send_verify_code', ['code' => $this->code]);
    }
}
