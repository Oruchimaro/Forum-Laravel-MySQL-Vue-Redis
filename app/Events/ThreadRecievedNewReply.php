<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadRecievedNewReply
{
    use Dispatchable,  SerializesModels;

    public $reply;

    public function __construct($reply)
    {
        $this->reply = $reply;
    }
}
