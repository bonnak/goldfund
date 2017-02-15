<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendCustomerRegisterInfo extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
                    ->view('emails.customer-info', [
                        'full_name'     => $notifiable->first_name . ' ' . $notifiable->last_name,
                        'id'            => $notifiable->id,
                        'username'      => $notifiable->username,
                        'password'      => $notifiable->password_store->password,
                        'trans_password'=> $notifiable->password_store->trans_password,
                        'sponsor_name'  => $notifiable->sponsor->first_name . ' ' . $notifiable->sponsor->last_name,
                        'sponsor_id'    => $notifiable->sponsor->id,
                    ]);
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
