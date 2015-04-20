<?php

class Accessor extends Eloquent 
{

    protected $table = 'users';

    public function scopeLogin($query, $email)
    {
    	$assessor = $query->where('email', '=', $email)->take(1)->get();
    	return $assessor;
    }
}