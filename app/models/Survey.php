<?php

class Survey extends \Eloquent {
	protected $fillable = [];

	public function assessor() {
		return $this->hasOne('User', 'id', 'user_id');
	}

	public function answers() {
		return $this->hasMany('Answer');
	}

	public function project() {
		return $this->hasOne('Project');
	}

	public function scopeUnanswered($query)
    {
    	$unanswered = $query->where('status', 0)->take(1)->get();
    	return $unanswered;
    }
}