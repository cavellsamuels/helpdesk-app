<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, Notifiable;

    public $mailInfo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailInfo)
    {
        $this->mailInfo = $mailInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Email.welcomeMail')
            ->with('mailInfo', $this->mailInfo);
    }
}
