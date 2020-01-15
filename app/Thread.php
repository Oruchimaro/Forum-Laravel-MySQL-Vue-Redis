<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\ThreadRecievedNewReply;
use Illuminate\Support\Facades\Redis;

class Thread extends Model
{

    use RecordsActivity, RecordsVisits;  // app\RecordActivity trait

    /********************* Properties ***********************/

    protected $guarded = [];

    protected $with = ['creator', 'channel'];  //Doc 8

    protected $appends = ['isSubscribedTo'];


    /********************* Methods ***********************/

    /**Doc7 */
    protected static function boot()
    {
        parent::boot();


        /** find every reply associated to the thread that is going to be deleted
         * and delete them with it.*/
        static::deleting(function ($thread) {

            $thread->replies->each->delete();
        });
    }

    /**
     * Fetch a path to the current thread.
     * 
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->channel->slug . '/' . $this->id;
    }



    /**
     * Add a reply to the thread
     * create a reply instance and save it
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadRecievedNewReply($reply));

        return $reply;
    }


    /**
     * Query scope on thread
     */

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }



    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id'  => $userId ?: auth()->id()
        ]);


        return $this;
    }


    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }


    public function hasUpdatesFor($user)
    {
        $user = $user ?: auth()->user();
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }


    /********************* Relationships ***********************/

    /**
     * Relation for Thread and Reply.
     * A Thread has many Replies. 1-M
     * 
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }


    /**
     * Relation For Thread and User.
     * A thread belons to a User.
     * 
     * Docs->3
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); //foreign-key is user_id
    }


    /**
     * Relation For Thread and User.
     * A thread belons to a User.
     * 
     * Docs->3
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }


    /** A thread can have many subscribers(subscriptions) */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscriptions::class);
    }
}
