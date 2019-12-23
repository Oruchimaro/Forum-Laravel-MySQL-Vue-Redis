<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
	protected $guarded = [];



	/** the subject relationship, so we can get the subject an activity.*/
	public function subject()
	{
		return $this->morphTo();
	}
}
