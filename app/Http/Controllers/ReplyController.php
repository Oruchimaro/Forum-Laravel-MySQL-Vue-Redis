<?php

namespace App\Http\Controllers;

use App\Http\Forms\CreatePostForm;
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



    public function store($channelId, Thread $thread, CreatePostForm $form)
    {
        return $form->persist($thread);
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
