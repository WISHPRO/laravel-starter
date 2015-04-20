<?php

class Group extends Eloquent 
{

    protected $table = 'groups';

    public function users()
	{
		return $this->hasOne('User');
	}
}