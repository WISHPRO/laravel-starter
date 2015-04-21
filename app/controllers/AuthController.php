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

		if ($user->inGroup($group_admin)) {
			return Redirect::to(route('admin'));
		} else {
			return Redirect::to(route('home'));
		}
	}

	public function GET_logoutUser()
	{
		Sentry::logout();
		return Redirect::to(route('_auth.login'));
	}

}
