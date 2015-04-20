<?php

class VpaDb extends \Eloquent {
	
	protected $fillable = [];
	protected $connection = 'mysql_old';
	protected $table = 'vpa_master_po';

}