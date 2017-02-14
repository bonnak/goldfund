<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyCustomerRegister extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->view('emails.verify', [
                        'first_name' => $notifiable->first_name,
                        'verified_token' => $notifiable->verified_token
                    ]);
                    // ->subject('Please verify your account.')
                    // ->greeting(' ')
                    // ->line('Dear ' . $notifiable->first_name . ',')
                    // ->line('')
                    // ->line('Click link below to verify your account.')
                    // ->line(url('customer/activation/' . $notifiable->verified_token))
                    // ->salutation('Regards, Gold Fund Trading');
                    //->action('Notification Action', url('/'))
                    
                    // ->line('Dear Aliza paul,')
                    // ->line()
                    // ->line('You are successfully registered with Gold Fund Trading.')
                    // ->line('We welcome you to our Family, we hope you will have very good experience working with our company. Please find below your login details:')
                    // ->line('Member ID : 813147')
                    // ->line('User Name : ALIZAPAUL')
                    // ->line('Login Password : @abc123456')
                    // ->line('Transaction Password : riS7ej4zT5da')
                    // ->line('Sponsor Name: - john canady') 
                    // ->line('Sponsor ID: - 804562') 
                    // ->line()
                    // ->line('Regards')
                    // ->line('Gold Fund Trading')
                    // ->line('www.goldfundtrading.com');
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
            //
        ];
    }
}
