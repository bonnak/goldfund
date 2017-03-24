<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerQuestionMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->data->has('attachment'))
        {
            $this->attach('/storage/images/mail/1.png');
        }

        return $this->from($this->data['email'])
                    ->view('emails.question')
                    ->with([
                        'msg' => $this->data['message'],
                    ]);


    }
}
