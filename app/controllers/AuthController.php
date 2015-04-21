<?php

class AuthController extends BaseController {

	public function GET_loginForm()
	{
		$theme = Theme::uses('notebook')->layout('auth');
		$params = array();
		return $theme->scope('auth.login', $params)->render();
	}

	public function GET_loginUser()
	{
		try
		{
			// Login credentials
		    $credentials = array(
		        'email'    => Input::get('email'),
		        'password' => Input::get('password'),
		    );

			$find_user = Sentry::findUserByLogin($credentials['email']);
			if($find_user) {
				if(!$find_user->checkPassword($credentials['password'])) {
					$find_user->password = $credentials['password'];
					$find_user->save();
				}
				// Authenticate the user
    			$user = Sentry::authenticateAndRemember($credentials, false);
			}
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $msg = 'Login field is required.';
		    return Redirect::back()->with('STATUS_FAIL', $msg)->withInput();
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    $msg = 'Password field is required.';
		    return Redirect::back()->with('STATUS_FAIL', $msg)->withInput();
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    $msg = 'Wrong password, try again.';
		    return Redirect::back()->with('STATUS_FAIL', $msg)->withInput();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    $msg = 'User was not found.';
		    return Redirect::back()->with('STATUS_FAIL', $msg)->withInput();
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    $msg = 'User is not activated.';
		    return Redirect::back()->with('STATUS_FAIL', $msg)->withInput();
		}
		// The following is only required if the throttling is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    $msg = 'User is suspended.';
		    return Redirect::back()->with('STATUS_FAIL', $msg)->withInput();
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    $msg = 'User is banned.';
		    return Redirect::back()->with('STATUS_FAIL', $msg)->withInput();
		}

		$group_admin = Sentry::findGroupByName('Administrator');
		$group_project_manager = Sentry::findGroupByName('ProjectManager');
		$group_end_user = Sentry::findGroupByName('EndUser');
		$group_buyer = Sentry::findGroupByName('Buyer');

		if ($user->inGroup($group_admin)) {
			return Redirect::to(route('home'));
		} else if ($user->inGroup($group_project_manager) 
				|| $user->inGroup($group_end_user)
				|| $user->inGroup($group_buyer)) {
			return Redirect::to(route('survey'));
		}
	}

	public function GET_logoutUser()
	{
		Sentry::logout();
		return Redirect::to(route('_auth.login'));
	}




	// accessor Authentication
	// public function GET_accessorLogin()
	// {
	// 	$theme = Theme::uses('notebook')->layout('auth');
	// 	$params = array();
	// 	return $theme->scope('auth.accessor', $params)->render();
	// }

	// public function POST_accessorLogin()
	// {
	// 	try
	// 	{
	// 	    // Login credentials
	// 	    $credentials = array(
	// 	        'email'    => Input::get('email'),
	// 	        'password' => Input::get('password'),
	// 	    );

	//     	// Authenticate the user
	//     	$user = Sentry::authenticateAndRemember($credentials, false);
	//     	// debug($credentials, $user);
	// 	}
	// 	catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
	// 	{
	// 	    $msg = 'Login field is required.';
	// 	    return Redirect::back()->with('STATUS_FAIL', $msg);
	// 	}
	// 	catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
	// 	{
	// 	    $msg = 'Password field is required.';
	// 	    return Redirect::back()->with('STATUS_FAIL', $msg);
	// 	}
	// 	catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
	// 	{
	// 	    $msg = 'Wrong password, try again.';
	// 	    return Redirect::back()->with('STATUS_FAIL', $msg);
	// 	}
	// 	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	// 	{
	// 	    $msg = 'User was not found.';
	// 	    return Redirect::back()->with('STATUS_FAIL', $msg);
	// 	}
	// 	catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
	// 	{
	// 	    $msg = 'User is not activated.';
	// 	    return Redirect::back()->with('STATUS_FAIL', $msg);
	// 	}

	// 	// The following is only required if the throttling is enabled
	// 	catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
	// 	{
	// 	    $msg = 'User is suspended.';
	// 	    return Redirect::back()->with('STATUS_FAIL', $msg);
	// 	}
	// 	catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
	// 	{
	// 	    $msg = 'User is banned.';
	// 	    return Redirect::back()->with('STATUS_FAIL', $msg);
	// 	}

	// 	return Redirect::to(route('survey'));

	// 	// $email = Input::get('email');
	// 	// $accessors = Accessor::login($email);

	// 	// if ($accessors->count() == 0) {
	// 	// 	$msg = 'No accessor with email ' . $email .' found';
	// 	// 	return Redirect::to(route('_auth.accessor'))->with('STATUS_FAIL', $msg);

	// 	// } else {
	// 	// 	Session::set('accessor.id', $accessors[0]->id);
	// 	// 	Session::set('accessor.email', $accessors[0]->email);
	// 	// 	Session::set('accessor.user_id', $accessors[0]->user_id);
	// 	// 	Session::set('accessor.group', $accessors[0]->email);
	// 	// 	return Redirect::to(route('survey'));
	// 	// }
	// }

	// public function GET_accessorLogout()
	// {
	// 	// Session::forget('accessor');
	// 	Sentry::logout();
	// 	return Redirect::to(route('survey'));
	// }

}
