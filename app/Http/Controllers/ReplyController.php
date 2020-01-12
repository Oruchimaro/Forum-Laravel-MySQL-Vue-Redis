<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;
use App\Thread;
use Illuminate\Support\Str;
use App\Inspections\Spam;

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





    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);


        //detect spam using Spam class
        $spam->detect(request('body'));

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
