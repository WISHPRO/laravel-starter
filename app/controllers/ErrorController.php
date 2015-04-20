<?php

class ErrorController extends BaseController {

	public function GET_error()
	{
		$theme = Theme::uses('notebook')->layout('error');
    	return $theme->scope('error.404')->render();
	}

}