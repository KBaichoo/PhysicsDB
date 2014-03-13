<?php

class Room extends Eloquent {
	protected $guarded = array();

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rooms';


	/**
	 * Defines a one-to-many relationship.
	 *
	 * @see http://laravel.com/docs/eloquent#one-to-many
	*/
  
  public function sections(){
      return $this->hasMany('Section');
  }

	public static $rules = array();
}
