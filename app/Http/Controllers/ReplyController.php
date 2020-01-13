<?php

namespace App\Http\Controllers;

//use App\Http\Forms\CreatePostForm;
use App\Http\Requests\CreatePostRequest;
use App\Reply;
use Illuminate\Http\Request;
use App\Thread;
use App\User;
use App\Notifications\YouWhereMentioned;

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



    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

        $names = $matches[1];
        foreach ($names as $name) {
            $user = User::whereName($name)->first();

            if ($user) {
                $user->notify(new YouWhereMentioned($reply));
            }
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
