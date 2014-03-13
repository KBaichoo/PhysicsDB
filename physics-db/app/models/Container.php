<?php

class Container extends Eloquent {
	protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'containers';

	public function items(){
    return $this->belongsToMany('Item');
	}

	public static $rules = array();
}
