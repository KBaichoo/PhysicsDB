<?php

class Item extends Eloquent {
	protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'items';


	public function containers(){
    return $this->belongsToMany('Container');
	}
	
	public static $rules = array();
}
