<?php

class Project extends \Eloquent 
{
	protected $fillable = [];

	public function vendor()
	{
		return $this->hasOne('Vendor', 'id', 'vendor_id');
	}

	public function vendorStatus()
	{
		return $this->hasOne('VendorStatus', 'id', 'vendor_status');
	}

	public function vendorType()
	{
		return $this->hasOne('VendorType', 'id', 'vendor_type');
	}

	public function method()
	{
		return $this->hasOne('Method', 'id', 'method');
	}

	public function company()
	{
		return $this->hasOne('Company', 'id', 'company');
	}

	public function survey()
	{
		return $this->hasMany('Survey');
	}
}