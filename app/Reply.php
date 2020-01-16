<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;  // app/Favoritable trait
    use RecordsActivity; // app/RecordsActivity trait

    protected $guarded = [];

    protected $with = ['owner', 'favorites']; //Docs 8

    //when you cast to an array or json is there any custom attribute that u want to
    //append to it ? then use appends attribute to add any custom attribute to
    protected $appends = ['favoritesCount', 'isFavorited'];


    /** Overriding the parent boot method */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }


    /**
     * Relation For Reply and User. A Reply belons to a User.
     * Docs->3
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id'); //foreign-key is user_id
    }



    /** Relation For Reply and Thread. A Reply Belongs to a use r*/
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }


    /** #reply-{$this->id} attachs the replys id to url */
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }


    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }


    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);

        return $matches[1]; //return matches minus '@' symbol
    }

    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body);
    }


    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }
}
