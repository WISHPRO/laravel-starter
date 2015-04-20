<?php

class VendorStatus extends \Eloquent {
	protected $table = 'vendor_status';
	protected $fillable = [];

	public function project() {
		return $this->belongsTo('Project');
	}
}