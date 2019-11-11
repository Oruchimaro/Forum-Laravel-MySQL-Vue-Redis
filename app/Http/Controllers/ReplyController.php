<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;

class ReplyController extends Controller
{
    /**
     * Protect this Controller with auth middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Store a new reply for a given thread
     * Doc->4
     */
    public function store(Thread $thread)
    {
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
