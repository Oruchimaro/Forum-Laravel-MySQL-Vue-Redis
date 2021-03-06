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
        'name', 'email', 'password', 'avatar_path'
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
        'confirmed' => 'boolean'

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


    //this method confirms the user account (sets confirmed to true)
    public function confirm()
    {
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }


    public function isAdmin()
    {
        return in_array($this->name, ['Amir', 'amir', 'Majid', 'majid']);
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

    public function avatar()
    {
        return "/storage/{$this->avatar_path}" ?: "/storage/avatars/default.png";
    }


    public function getAvatarPathAttribute($avatar)
    {
        return $avatar ?: "avatars/default.png";
    }
}
