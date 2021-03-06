<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});


App::missing(function($exception)
{
	return Redirect::to(route('_error'));
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (!Sentry::check()) return Redirect::guest('login');
});

Route::filter('permissions', function()
{
	$user = Sentry::getUser();
	$user_groups = $user->getGroups();

	$permits = array();
	foreach ($user_groups as $key => $group) {
		foreach ($group->permissions as $permission => $val) {
			if($permission == Route::current()->getName()) {
				$access = Sentry::findGroupByName($group->name);
				$permits[] = $access;
			}
		}
	}

	if (!array_filter($permits)) {
		return Redirect::to('login')->with('STATUS_FAIL', 'You do not have access to this page.');
	}

});
/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

// Route::filter('accessor', function()
// {
// 	if (!Session::get('accessor.email')) return Redirect::to(route('_auth.accessor'));
// });

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
