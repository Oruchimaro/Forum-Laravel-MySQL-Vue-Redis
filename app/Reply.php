<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];


    /**
     * Relation For Reply and User.
     * A Reply belons to a User.
     * 
     * Docs->3
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id'); //foreign-key is user_id
    }

    public function favorites()
    {
      return $this->morphMany(Favorite::class, 'favorited');
    }


    //method for favoriting a reply
    public function favorite()
    {
      $attributes = ['user_id' => auth()->id()];

      if(! $this->favorites()->where($attributes)->exists() )
      {
        $this->favorites()->create($attributes);
      }
    }
}
