<?php

namespace App\Filters;
use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];
    /**
     * Filter Query by a username
     * @param string $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id ); 
    }


    /**
     * Filter The Query according to most popular threads. (with most replies)
     */
    protected function popular()
    {
        //removing the current order method (in getThreads there is a latest)
        $this->builder->getQuery()->orders = []; //getQuery() returns a instance of queryBulider

        return $this->builder->orderBy('replies_count', 'desc');
    }
}