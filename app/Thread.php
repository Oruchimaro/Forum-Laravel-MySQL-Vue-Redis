<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $guarded = [];

	protected $with = ['creator', 'channel'];  //Doc 8

	/**Doc7 */
	protected static function boot()
	{
		parent::boot();

		/**adding repliesCount to every Thread instance */
		static::addGlobalScope('replyCount', function ($builder) {
			$builder->withCount('replies');
		});


		/** find every reply associated to the thread that is going to be deleted
		 * and delete them with it.*/
		static::deleting(function ($thread) {
			$thread->replies()->delete();
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


	/**
	 * Add a reply to the thread
	 * create a reply instance and save it
	 */
	public function addReply($reply)
	{
		$this->replies()->create($reply);
	}



	/**
	 * Query scope on thread
	 */

	public function scopeFilter($query, $filters)
	{
		return $filters->apply($query);
	}
}
