<?php

/**
* 
*/
class UserController extends BaseController
{

	public function GET_listUser()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('user.user');

		$users = User::all();
		
		$params = array('users' => $users);
		return $theme->scope('user.list', $params)->render();
	}
	
	public function GET_createUserForm()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('user.user');

		$theme->asset()->container('post-scripts')->usePath()->add('typeahead', 'js/typeahead/bootstrap3-typeahead.js');
		$theme->asset()->container('post-scripts')->usePath()->add('custom', 'js/custom.js');

		$groups = Sentry::findAllGroups();

		$params = array('groups' => $groups);
		return $theme->scope('user.create', $params)->render();
	}

	public function POST_createUser()
	{
		try
		{
			$user = Sentry::createUser(array(
		        'email'    => Input::get('email'),
		        'password' => Input::get('password'),
		        'first_name' => Input::get('full_name'),
		        'employee_id' => Input::get('employee_id'),
		        'department' => Input::get('department'),
		        'designation' => Input::get('designation'),
		        'activated' => true,
		    ));

			$groups = Input::get('groups');
			if (is_array($groups)) {
				foreach ($groups as $key => $group) {
					$adminGroup = Sentry::findGroupById($group);
			    	$user->addGroup($adminGroup);
				}
			}
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $msg = 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    $msg = 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    $msg = 'User with this login already exists.';
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    $msg = 'Group was not found.';
		}

		if (!empty($msg)) {
			return Redirect::to(route('user.list'))->with('STATUS_FAIL', $msg);
		} else {
			return Redirect::to(route('user.list'))->with('STATUS_OK', 'User `'.Input::get('email').'` successfully created.');
		}
	}

	public function GET_updateUserForm($id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('user.user');

		$user = Sentry::findUserById($id);
		$ugroups = $user->getGroups();
		$user_groups = array();
		foreach ($ugroups as $key => $usergrp) {
			$user_groups[$usergrp->id] = $usergrp->name;
		}
		
		$groups = Sentry::findAllGroups();

		$params = array('user' => $user, 'groups' => $groups, 'user_groups' => $user_groups);
		return $theme->scope('user.update', $params)->render();
	}

	public function PUT_updateUser($id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('user.user');

		try
		{
			$user = Sentry::findUserById($id);
			$user->email = Input::get('email');
		    $user->first_name = Input::get('full_name');
		    $user->employee_id = Input::get('employee_id');
		    $user->department = Input::get('department');
		    $user->designation = Input::get('designation');
		    if(Input::has('password')) $user->password = Input::get('password');

		    $all_groups = Sentry::findAllGroups();
		    if (is_array($all_groups)) {
				foreach ($all_groups as $key => $all_group) {
					$findGroup = Sentry::findGroupById($all_group->id);
					$user->removeGroup($findGroup);
				}
			}

			$groups = Input::get('groups');
			if (is_array($groups)) {
				foreach ($groups as $key => $group) {
					$adminGroup = Sentry::findGroupById($group);
			    	$user->addGroup($adminGroup);
				}
			}

			if ($user->save()) {
		        $success = 'User information was updated';
		    } else {
		        $failed = 'User information was not updated';
		    }
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $failed = 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    $failed = 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    $failed = 'User with this login already exists.';
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    $failed = 'Group was not found.';
		}

		if (!empty($failed)) {
			return Redirect::to(route('user.list'))->with('STATUS_FAIL', $failed);
		} else if (!empty($success)) {
			return Redirect::to(route('user.list'))->with('STATUS_OK', $success);
		}
	}

	public function DELETE_deleteUser($id)
	{
		try {
		    $user = Sentry::findUserById($id);
		    $user->delete();

		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
		    echo 'User was not found.';
		}
		
		return Redirect::to(route('user.list'));
	}


}

?>