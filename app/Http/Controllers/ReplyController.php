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





    public function store($channelId, Thread $thread)
    {
        try {

            $this->validateReply();

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

            $this->validateReply();

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


    public function validateReply()
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        //detect spam using Spam class
        resolve(Spam::class)->detect(request('body'));
    }
}
