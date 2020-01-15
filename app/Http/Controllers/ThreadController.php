<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use Illuminate\Support\Facades\Redis;

class ThreadController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }


    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }


        $trending = collect(Redis::zrevrange('trending_threads', 0, 4))->map(function ($thread) {
            return json_decode($thread);
        });
        //$trending = array_map('json_decode', Redis::zrevrange('trending_threads', 0, 4)); //same above

        return view('threads.index', compact('threads', 'trending'));
    }


    public function create()
    {
        return view('threads.create');
    }




    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => ['required', 'exists:channels,id']
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect($thread->path())
            ->with('flash', 'Your thread has beedn published !!!');
    }





    public function show($channel, Thread $thread)
    {
        //recording if the user has read the latest update of the thread.
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        Redis::zincrby('trending_threads', 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));

        return view('threads.show', compact('thread'));
    }



    public function update(Request $request, Thread $thread)
    {
        //
    }




    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);  //204:its done, but there is nothing to return
        }

        return redirect('/threads');
    }



    /**
     * get the latest thread by filter
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(5);
    }
}
