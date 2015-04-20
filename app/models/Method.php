<?php

class Method extends \Eloquent {
	protected $fillable = [];

	public function project() {
		return $this->belongsTo('Project');
	}
}