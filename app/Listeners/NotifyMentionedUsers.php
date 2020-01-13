<?php

namespace App\Listeners;

use App\Events\ThreadRecievedNewReply;
use App\User;
use App\Notifications\YouWhereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadRecievedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecievedNewReply $event)
    {
        User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWhereMentioned($event->reply));
            });
    }
}
