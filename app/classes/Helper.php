<?php

class Helper {

	public static function set_active($route, $active = 'active')
	{
		$menus = explode('.', Theme::getMenu());
	    return (($route == $menus[0]) || $route == Theme::getMenu()) ? $active : '';
	}

	public static function bootstrap_alert()
	{
		if(Session::has('STATUS_OK')) {
			echo '<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h5>
					<i class="fa fa-check" style="margin-left:20px;font-size:150%;display:inline;"></i>
					<div style="margin-left:10px;display:inline">' . Session::get('STATUS_OK') . '</div>
				</h5>
			</div>';
			
		} else if(Session::has('STATUS_FAIL')) {
			echo '<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h5>
					<i class="fa fa-warning" style="margin-left:20px;font-size:150%;display:inline;"></i>
					<div style="margin-left:10px;display:inline">' . Session::get('STATUS_FAIL') . '</div>
				</h5>
			</div>';
		}
	}

	public static function ordinal($number) 
	{
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if (($number %100) >= 11 && ($number%100) <= 13)
			$abbreviation = $number. '<sup>th</sup>';
		else
			$abbreviation = $number. '<sup>' . $ends[$number % 10] . '</sup>';
		return $abbreviation;
	}

	public static function dateToString($dt)
	{
		if (strtotime($dt) <= 0) {
			return '';
		} else {
			$date = new Date($dt);
			return $date->format('d-m-Y');
		}
	}

	public static function stringToDate($dt)
	{
		$date = new Date($dt);
		return $date->format('Y-m-d H:i:s');
	}

}