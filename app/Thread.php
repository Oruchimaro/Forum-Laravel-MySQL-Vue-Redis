<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    
    /**
     * Fetch a path to the current thread.
     * 
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->id ;
    }


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


    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
