<?php

/**
* 
*/
class GroupController extends BaseController
{

	// Groups
	public function GET_assignGroupForm()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('user.group');
		
		$routes = Route::getRoutes();
		$groups = Sentry::findAllGroups();

		$permits = array();
		if(is_array($groups)) {
			foreach ($groups as $group) {
				$findGroup = Sentry::findGroupById($group->id);
				$permissions = $findGroup->getPermissions();
				$permits[$group->name] = array();
				foreach ($permissions as $key => $permission) {
					$permits[$group->name][] = $key;
				}
			}
		}

		$params = array('routes' => $routes, 'groups' => $groups, 'permits' => $permits);
		return $theme->scope('user.group-assign', $params)->render();
	}

	public function POST_assignGroup($params)
	{
		$ex_params = explode('_', $params);
		$group_name = ucfirst($ex_params[0]);
		$route = $ex_params[1];
		$action = $ex_params[2];

		$group = Sentry::findGroupByName($group_name);
		$permits = $group->permissions;

		if ($action == 'push') {
			$permits[$route] = 1;
			$msg = 'Route `'.$route.'` successfully added to group `'.$group_name.'`';
		} else if($action == 'pop') {
			$permits[$route] = 0;
			$msg = 'Route `'.$route.'` successfully removed from group `'.$group_name.'`';
		} else {
			return Redirect::to(route('group.assign'));
		}

		$group->permissions = $permits;
		if ($group->save()) {
	        return Redirect::to(route('group.assign', '#'.$route))->with('STATUS_OK', $msg);
	    } else {
	        return Redirect::to(route('group.assign', '#'.$route))->with('STATUS_FAIL', $msg);
	    }
	}
	
	public function GET_createGroupForm()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('user.group');

		$routeCollection = Route::getRoutes();

		$params = array('routes' => $routeCollection);
		return $theme->scope('user.group-create', $params)->render();
	}

	public function POST_createGroup()
	{
		$ar_grps = Input::get('routes');
		$ar_groups = array();

		if(is_array($ar_grps)) {
			foreach ($ar_grps as $key => $grp) {
				$ar_groups[$grp] = 1;
			}
		}

		try {
		    // Create the group
		    $group = Sentry::createGroup(array(
		        'name'        => Input::get('group_name'),
		        'permissions' => $ar_groups,
		    ));
		} catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
		    echo 'Name field is required';
		} catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
		    echo 'Group already exists';
		}
		
		return Redirect::to(route('group.assign'));
	}

	public function DELETE_deleteGroup($id)
	{
		try {
		    $group = Sentry::findGroupById($id);
		    $group_name = $group->name;
		    $group->delete();

		} catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
		    return Redirect::to(route('group.assign'))->with('STATUS_FAIL', 'Group was not found.');
		}
		
		return Redirect::to(route('group.assign'))->with('STATUS_OK', 'Group `'.$group_name.'` successfully deleted.');
	}


}

?>