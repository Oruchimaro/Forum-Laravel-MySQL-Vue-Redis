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


        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back()->with('flash', 'Your Reply has been left!!!');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(Request(['body']));

        return response()->json(['updated', 200]); //->with('flash', 'reply updated');
    }



    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back()->with('flash', 'The Reply has been deleted!!!');
    }
}
