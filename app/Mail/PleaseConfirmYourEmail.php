<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PleaseConfirmYourEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    //all the public properties will be available to mail
    public $user;


    public function __construct($user)
    {
        $this->user = $user;
    }


    public function build()
    {
        return $this->markdown('emails.confirm-email');
    }
}
