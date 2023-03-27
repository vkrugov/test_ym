<?php

namespace App\Notifications;

use GuzzleHttp\Psr7\Query;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordEmail extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @param $token
     * @param $email
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Oof! Forgot your password')
            ->from('ym@test.com')
            ->view('mails.auth.reset-password', [
                'name' => $notifiable->profile->first_name,
                'email' => $notifiable->email,
                'resetUrl' => $this->createFrontendUrl('frontend.url.reset_password', [
                    'action' => 'reset-password',
                    'token' => $this->token,
                    'email' => $this->email
                ])
            ])->subject(trans('Password Change Request.'));
    }

    /**
     * @param string $configKey
     * @param array  $queryParams
     *
     * @return string
     */
    public function createFrontendUrl(string $configKey, array $queryParams = []): string
    {
        $url = config('frontend.url.base') . config($configKey);

        if (count($queryParams) > 0) {
            $url .= '?' . Query::build($queryParams);
        }

        return $url;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
