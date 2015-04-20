<?php

class Answer extends \Eloquent {
	protected $fillable = [];

	public function survey() {
		return $this->belongsTo('Survey');
	}
}