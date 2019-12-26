<?php

namespace App;

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
}
