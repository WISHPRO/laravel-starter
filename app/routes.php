<?php

// Authentication
Route::get(		'/login', 					['as' => '_auth.login', 				'uses' => 'AuthController@GET_loginForm']);
Route::post(	'/login', 					['as' => '_auth.login.post', 			'uses' => 'AuthController@GET_loginUser']);
Route::get(		'/logout', 					['as' => '_auth.logout', 				'uses' => 'AuthController@GET_logoutUser']);
// Error controller
Route::get(		'/error', 					['as' => '_error', 						'uses' => 'ErrorController@GET_error']);
// Home
Route::get(		'/', 						['as' => 'home', 						'uses' => 'HomeController@GET_index']);

Route::group(['before' => 'auth|permissions'], function()
{
	// Admin
	Route::get(		'/admin', 				['as' => 'admin', 						'uses' => 'AdminController@GET_index']);

	// Create User
	Route::get(		'/user/list', 			['as' => 'user.list', 					'uses' => 'UserController@GET_listUser']);
	Route::get(		'/user/create', 		['as' => 'user.create', 				'uses' => 'UserController@GET_createUserForm']);
	Route::post(	'/user/create', 		['as' => 'user.create.post', 			'uses' => 'UserController@POST_createUser']);
	Route::get(		'/user/update/{id}', 	['as' => 'user.update', 				'uses' => 'UserController@GET_updateUserForm']);
	Route::put(		'/user/update/{id}', 	['as' => 'user.update.put', 			'uses' => 'UserController@PUT_updateUser']);
	Route::delete(	'/user/delete/{id}', 	['as' => 'user.delete', 				'uses' => 'UserController@DELETE_deleteUser']);

	// Create Group
	Route::delete(	'/group/delete/{id}', 	['as' => 'group.delete', 				'uses' => 'GroupController@DELETE_deleteGroup']);
	Route::get(		'/group/create', 		['as' => 'group.create', 				'uses' => 'GroupController@GET_createGroupForm']);
	Route::post(	'/group/create', 		['as' => 'group.create.post',		 	'uses' => 'GroupController@POST_createGroup']);
	Route::get(		'/group/assign', 		['as' => 'group.assign', 				'uses' => 'GroupController@GET_assignGroupForm']);
	Route::post(	'/group/assign/{id}', 	['as' => 'group.assign.post', 			'uses' => 'GroupController@POST_assignGroup']);

});