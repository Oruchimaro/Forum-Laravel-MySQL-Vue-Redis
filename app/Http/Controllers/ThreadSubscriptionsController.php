<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    /** Subscribe  a user to a thread */
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }
}
