<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Admin Authentication
Route::get(		'/login', 						['as' => '_auth.login', 				'uses' => 'AuthController@GET_loginForm']);
Route::post(	'/login', 						['as' => '_auth.login.post', 			'uses' => 'AuthController@GET_loginUser']);
Route::get(		'/logout', 						['as' => '_auth.logout', 				'uses' => 'AuthController@GET_logoutUser']);
// Error controller
Route::get(		'/_error', 						['as' => 'error', 						'uses' => 'ErrorController@GET_error']);
// RESTful
Route::get(		'/api/vendors.json', 			['as' => '_api.vendors', 				'uses' => 'APIController@GET_vendors']);
Route::get(		'/api/buyers.json', 			['as' => '_api.buyers', 				'uses' => 'APIController@GET_buyers']);
Route::get(		'/api/employees.json', 			['as' => '_api.employees', 				'uses' => 'APIController@GET_employees']);
Route::get(		'/api/update_employees',		['as' => '_api.update_employees_db',	'uses' => 'APIController@GET_update_db']);
Route::get(		'/api/migration',				['as' => '_api.migration',				'uses' => 'APIController@GET_migration']);
Route::get(		'/api/migration/vendor',		['as' => '_api.migration.vendor',		'uses' => 'APIController@GET_migrationVendor']);
Route::get(		'/api/migration/buyer',			['as' => '_api.migration.buyer',		'uses' => 'APIController@GET_migrationBuyer']);

Route::get(		'/email/survey',				['as' => '_email.survey',				'uses' => 'EmailController@GET_survey']);
Route::get(		'/email/welcome',				['as' => '_email.welcome',				'uses' => 'EmailController@GET_welcome']);


Route::group(['before' => 'auth|permissions'], function()
{

	Route::get(		'/', 						['as' => 'home', 						'uses' => 'HomeController@GET_index']);

	// Configs - consultant
	Route::get(		'/config/consultant',		['as' => 'config.consultant', 			'uses' => 'ConfigController@GET_consultant']);
	Route::post(	'/config/consultant',		['as' => 'config.consultant.post', 		'uses' => 'ConfigController@POST_consultant']);
	Route::get(		'/config/consultant/{id}',	['as' => 'config.consultant.update', 	'uses' => 'ConfigController@GET_consultantUpdate']);
	Route::put(		'/config/consultant/{id}',	['as' => 'config.consultant.put', 		'uses' => 'ConfigController@PUT_consultant']);
	Route::delete(	'/config/consultant/{id}',	['as' => 'config.consultant.delete',	'uses' => 'ConfigController@DELETE_consultant']);
	// Configs - contractor
	Route::get(		'/config/contractor',		['as' => 'config.contractor', 			'uses' => 'ConfigController@GET_contractor']);
	Route::post(	'/config/contractor',		['as' => 'config.contractor.post', 		'uses' => 'ConfigController@POST_contractor']);
	Route::get(		'/config/contractor/{id}',	['as' => 'config.contractor.update', 	'uses' => 'ConfigController@GET_contractorUpdate']);
	Route::put(		'/config/contractor/{id}',	['as' => 'config.contractor.put', 		'uses' => 'ConfigController@PUT_contractor']);
	Route::delete(	'/config/contractor/{id}',	['as' => 'config.contractor.delete',	'uses' => 'ConfigController@DELETE_contractor']);
	// Configs - supplier
	Route::get(		'/config/supplier',			['as' => 'config.supplier', 			'uses' => 'ConfigController@GET_supplier']);
	Route::post(	'/config/supplier',			['as' => 'config.supplier.post', 		'uses' => 'ConfigController@POST_supplier']);
	Route::get(		'/config/supplier/{id}',	['as' => 'config.supplier.update', 		'uses' => 'ConfigController@GET_supplierUpdate']);
	Route::put(		'/config/supplier/{id}',	['as' => 'config.supplier.put', 		'uses' => 'ConfigController@PUT_supplier']);
	Route::delete(	'/config/supplier/{id}',	['as' => 'config.supplier.delete',		'uses' => 'ConfigController@DELETE_supplier']);
	// Configs - buyers
	Route::get(		'/config/buyer',			['as' => 'config.buyer', 				'uses' => 'ConfigController@GET_buyer']);
	Route::post(	'/config/buyer',			['as' => 'config.buyer.post', 			'uses' => 'ConfigController@POST_buyer']);
	Route::get(		'/config/buyer/{id}',		['as' => 'config.buyer.update', 		'uses' => 'ConfigController@GET_buyerUpdate']);
	Route::put(		'/config/buyer/{id}',		['as' => 'config.buyer.put', 			'uses' => 'ConfigController@PUT_buyer']);
	Route::delete(	'/config/buyer/{id}',		['as' => 'config.buyer.delete',			'uses' => 'ConfigController@DELETE_buyer']);
	// Configs - vendors
	Route::get(		'/config/vendor',			['as' => 'config.vendor', 				'uses' => 'ConfigController@GET_vendor']);
	Route::post(	'/config/vendor',			['as' => 'config.vendor.post', 			'uses' => 'ConfigController@POST_vendor']);
	Route::get(		'/config/vendor/{id}',		['as' => 'config.vendor.update', 		'uses' => 'ConfigController@GET_vendorUpdate']);
	Route::put(		'/config/vendor/{id}',		['as' => 'config.vendor.put', 			'uses' => 'ConfigController@PUT_vendor']);
	Route::delete(	'/config/vendor/{id}',		['as' => 'config.vendor.delete',		'uses' => 'ConfigController@DELETE_vendor']);

	// Search
	Route::get(		'/search', 					['as' => 'search', 						'uses' => 'SearchController@GET_search']);
	Route::post(	'/search', 					['as' => 'search.post', 				'uses' => 'SearchController@POST_search']);
	
	Route::get(		'/list/display/{id}', 		['as' => 'list.display', 				'uses' => 'ListController@GET_display']);
	Route::get(		'/list/vendor/{id}', 		['as' => 'list.vendor', 				'uses' => 'ListController@GET_vendor']);
	Route::get(		'/list/score/{id}', 		['as' => 'list.score', 					'uses' => 'ListController@GET_score']);
	// list - consultant	
	Route::get(		'/list/consultant/{id}',	['as' => 'list.consultant.id', 			'uses' => 'ListController@GET_consultantDetails']);
	Route::get(		'/list/consultant',			['as' => 'list.consultant', 			'uses' => 'ListController@GET_consultant']);
	Route::post(	'/list/consultant',			['as' => 'list.consultant.post', 		'uses' => 'ListController@POST_consultant']);
	Route::delete(	'/list/consultant/{id}', 	['as' => 'list.consultant.delete', 		'uses' => 'ListController@DELETE_consultant']);
	// list - contractor
	Route::get(		'/list/contractor/{id}',	['as' => 'list.contractor.id', 			'uses' => 'ListController@GET_contractorDetails']);
	Route::get(		'/list/contractor',			['as' => 'list.contractor', 			'uses' => 'ListController@GET_contractor']);
	Route::post(	'/list/contractor',			['as' => 'list.contractor.post', 		'uses' => 'ListController@POST_contractor']);
	Route::delete(	'/list/contractor/{id}', 	['as' => 'list.contractor.delete', 		'uses' => 'ListController@DELETE_contractor']);
	// list - supplier
	Route::get(		'/list/supplier/{id}',		['as' => 'list.supplier.id', 			'uses' => 'ListController@GET_supplierDetails']);
	Route::get(		'/list/supplier',			['as' => 'list.supplier', 				'uses' => 'ListController@GET_supplier']);
	Route::post(	'/list/supplier',			['as' => 'list.supplier.post', 			'uses' => 'ListController@POST_supplier']);
	Route::delete(	'/list/supplier/{id}', 		['as' => 'list.supplier.delete', 		'uses' => 'ListController@DELETE_supplier']);

	// Create User
	Route::get(		'/user/list', 			['as' => 'user.list', 			'uses' => 'UserController@GET_listUser']);
	Route::get(		'/user/create', 		['as' => 'user.create', 		'uses' => 'UserController@GET_createUserForm']);
	Route::post(	'/user/create', 		['as' => 'user.create.post', 	'uses' => 'UserController@POST_createUser']);
	Route::get(		'/user/update/{id}', 	['as' => 'user.update', 		'uses' => 'UserController@GET_updateUserForm']);
	Route::put(		'/user/update/{id}', 	['as' => 'user.update.put', 	'uses' => 'UserController@PUT_updateUser']);
	Route::delete(	'/user/delete/{id}', 	['as' => 'user.delete', 		'uses' => 'UserController@DELETE_deleteUser']);

	// Create Group
	Route::delete(	'/group/delete/{id}', 	['as' => 'group.delete', 		'uses' => 'GroupController@DELETE_deleteGroup']);
	Route::get(		'/group/create', 		['as' => 'group.create', 		'uses' => 'GroupController@GET_createGroupForm']);
	Route::post(	'/group/create', 		['as' => 'group.create.post', 	'uses' => 'GroupController@POST_createGroup']);
	Route::get(		'/group/assign', 		['as' => 'group.assign', 		'uses' => 'GroupController@GET_assignGroupForm']);
	Route::post(	'/group/assign/{id}', 	['as' => 'group.assign.post', 	'uses' => 'GroupController@POST_assignGroup']);

	// List record
	// Route::get(		'/list', 				['as' => 'list.new', 			'uses' => 'ListController@GET_new']);
	// Route::get(		'/list/new', 			['as' => 'list.new', 			'uses' => 'ListController@GET_new']);
	// Route::get(		'/list/sent', 			['as' => 'list.sent', 			'uses' => 'ListController@GET_sent']);
	// Route::get(		'/list/completed', 		['as' => 'list.completed', 		'uses' => 'ListController@GET_completed']);
	// Route::get(		'/list/display/{id}', 	['as' => 'list.display', 		'uses' => 'ListController@GET_display']);
	
	// Create Record
	Route::get(		'/create', 				['as' => 'create.index', 		'uses' => 'CreateController@GET_create']);
	Route::get(		'/create/{new}', 		['as' => 'create.index', 		'uses' => 'CreateController@GET_createIndex']);
	Route::post(	'/create',				['as' => 'create.index.post', 	'uses' => 'CreateController@POST_createIndex']);
	// Edit Record
	Route::get(		'/edit/{type}/{id}', 	['as' => 'edit.index', 			'uses' => 'CreateController@GET_editIndex']);
	Route::put(		'/edit',				['as' => 'edit.index.put', 		'uses' => 'CreateController@PUT_editIndex']);




	// SURVEY
	Route::get(		'/survey',					['as' => 'survey', 					'uses' => 'SurveyController@GET_index']);
	// Route::get(		'/survey/sent',				['as' => 'survey.sent', 			'uses' => 'SurveyController@GET_sent']);
	Route::get(		'/survey/done',				['as' => 'survey.done', 			'uses' => 'SurveyController@GET_done']);
	Route::get(		'/survey/display/{id}', 	['as' => 'survey.display', 			'uses' => 'SurveyController@GET_display']);
	// survey - settings
	Route::get(		'/survey/settings', 		['as' => 'survey.setting', 			'uses' => 'SurveyController@GET_updateUserForm']);
	Route::put(		'/survey/settings', 		['as' => 'survey.setting.put', 		'uses' => 'SurveyController@PUT_updateUser']);
	// survey - consultant	
	Route::get(		'/survey/consultant/{id}',	['as' => 'survey.consultant', 		'uses' => 'SurveyController@GET_consultant']);
	Route::post(	'/survey/consultant',		['as' => 'survey.consultant.post', 	'uses' => 'SurveyController@POST_consultant']);
	// survey - contractor
	Route::get(		'/survey/contractor/{id}',	['as' => 'survey.contractor', 		'uses' => 'SurveyController@GET_contractor']);
	Route::post(	'/survey/contractor',		['as' => 'survey.contractor.post', 	'uses' => 'SurveyController@POST_contractor']);
	// survey - supplier
	Route::get(		'/survey/supplier/{id}',	['as' => 'survey.supplier', 		'uses' => 'SurveyController@GET_supplier']);
	Route::post(	'/survey/supplier',			['as' => 'survey.supplier.post', 	'uses' => 'SurveyController@POST_supplier']);


});