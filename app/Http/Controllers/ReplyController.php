<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;
use App\Thread;
use Illuminate\Support\Str;

class ReplyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }


    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }



    public function store($channelId, Thread $thread)
    {
        //protect against spam creating replies
        if (Gate::denies('create', new Reply)) {
            return response('You are posting Too Frequently, Take a break :)', 422);
        }

        try {
            request()->validate(['body' => 'required|spamfree']);

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {

            return response('Sorry, Reply couldnt be saved at this time !', 422);
        }

        return $reply->load('owner');
    }





    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {

            request()->validate(['body' => 'required|spamfree']);

            $reply->update(Request(['body']));
        } catch (\Exception $e) {

            return response('Sorry, Reply Couldnt be updated at this time !', 422);
        }

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
