<?php

class VendorType extends \Eloquent {
	
	protected $fillable = ['id', 'type'];

	public function project() {
		return $this->belongsTo('Project');
	}
}