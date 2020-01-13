<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function getRouteKeyName()
    {
        return 'name';
    }


    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }


    public function activity()
    {
        return $this->hasMany(Activity::class);
    }


    /** the key that is used for saving a users last visit to cahce */
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id); //users.50.visits.1
    }


    /** the method that records the last time a thread was visited by a user. */
    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }


    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }
}
