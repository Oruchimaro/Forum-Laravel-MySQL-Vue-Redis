<?php

namespace App\Http\Controllers;

use App\Reply;
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
     * 
     * @param $channelId
     * @param Thread $thread
     * @return \RedirectResponse
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);


        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Your Reply has been left!!!');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(Request(['body']));

        return response()->json([
            'status' => 'Reply Updated !!!'
        ]);
    }



    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted']);
        }

        return back()->with('flash', 'The Reply has been deleted!!!');
    }
}
