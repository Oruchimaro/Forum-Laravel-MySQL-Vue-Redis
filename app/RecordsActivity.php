<?php

namespace App;


trait RecordsActivity
{

	/** Doc 10 */
	protected static function bootRecordsActivity()
	{
		foreach (static::getActivitiesToRecord() as $event) {

			static::$event(function ($model) use ($event) {
				$model->recordActivity($event);
			});
		}
	}




	/** for making the activity type dynamic*/
	protected static function getActivitiesToRecord()
	{
		return ['created'];
	}



	protected function recordActivity($event)
	{

		$this->activity()->create([
			'user_id' 		=> auth()->id(),
			'type' 			=> $this->getActivityType($event),
		]);
	}



	/** A Polymorphic Many Relationship
	 * This is used instead of hasMany relation on given Model
	 * so we can prevent hardcoding this on every model.
	 */
	public function activity()
	{
		return $this->morphMany('App\Activity', 'subject'); //subject the naming convetion for relationships
	}





	protected function getActivityType($event)
	{
		/** getShortName from ReflectionClass does this : App\Foo\Thread -> Thread */
		$type = strtolower((new \ReflectionClass($this))->getShortName());

		return  "{$event}_{$type}";
	}
}
