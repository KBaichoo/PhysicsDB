<?php

class Section extends Eloquent {
	protected $guarded = array();

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sections';

	public static $rules = array();

	/**
   * Defines a one-to-many relationship.
   *
   * @see http://laravel.com/docs/eloquent#one-to-many
  */
    public function room()
    {
        return $this->belongsTo('Room');
    }
}
