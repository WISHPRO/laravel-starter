<?php

class UserGroup extends Eloquent 
{

	public $timestamps = false;
    protected $table = 'users_groups';

    public function users_groups()
	{
		// return $this->hasMany('User')
		// 			->hasMany('Group');
	}
}