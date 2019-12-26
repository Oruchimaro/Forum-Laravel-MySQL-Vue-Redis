<?php

namespace App;

trait Favoritable
{
    /** Plymorphic relation For Reply with Favorites class */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }


    /** method for favoriting a reply */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }


    /** method for unfavoriting a favorited item */
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->delete();
    }


    /** Returns a boolean */
    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }


    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }


    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
