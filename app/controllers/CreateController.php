<?php

/**
* 
*/
class CreateController extends BaseController
{
	
	public function GET_create()
	{
		return $this->GET_createIndex('CAPEX');
	}

	public function GET_createIndex($new)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('create.index');
		
		// params
		$vendor_types = getVendorTypes();
		$vendor_status = getVendorStatus();
		$methods = getMethods();
		$company = getCompanies();

		$params = array(
			'vendor_types' => $vendor_types,
			'vendor_status' => $vendor_status,
			'methods' => $methods,
			'company' => $company,
			'new' => $new
			);

		// css
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker-css', 'js/datepicker/datepicker.css');
		$theme->asset()->usePath()->add('typeahead-css', 'css/typeaheadjs.css');
		// post scripts
		// $theme->asset()->container('post-scripts')->usePath()->add('hotkeys', 'js/wysiwyg/jquery.hotkeys.js');
		// $theme->asset()->container('post-scripts')->usePath()->add('wysiwyg', 'js/wysiwyg/bootstrap-wysiwyg.js');
		// $theme->asset()->container('post-scripts')->usePath()->add('wysiwyg-demo', 'js/wysiwyg/demo.js');
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker', 'js/datepicker/bootstrap-datepicker.js');
		$theme->asset()->container('post-scripts')->usePath()->add('typeahead', 'js/typeahead/typeahead.js');
		// $theme->asset()->container('post-scripts')->usePath()->add('custom', 'js/custom.js');
		$theme->asset()->container('post-scripts')->usePath()->add('custom', 'js/custom.js?'.time());
		
		return $theme->scope('create.index', $params)->render();
	}

	public function POST_createIndex()
	{

		$validator = Validator::make(Input::all(), array(
			'project_type' 			=> 'required',
			'vendor_type' 			=> 'required',
			'method' 				=> 'required',
			'company' 				=> 'required',
			'vendor_id' 			=> 'required',
			'vendor_status' 		=> 'required',
			'project_number' 		=> 'required',
			'scope_of_work' 		=> 'required',
			'buyer_id' 				=> 'required_without_all:project_manager_id,end_user_id',
			// 'contract_period' 		=> 'required',
			'issuance_date' 		=> 'required|date_format:d-m-Y',
			// 'estimate_date' 		=> 'required|date_format:d-m-Y',
			'actual_date' 			=> 'required|date_format:d-m-Y',
			'project_manager_id' 	=> 'required_without_all:end_user_id,buyer_id',
			'end_user_id' 			=> 'required_without_all:project_manager_id,buyer_id',
			// 'gpd_head' 				=> 'required',
		));

		if ($validator->fails()) {
			$error_str = '';
			foreach ($validator->messages()->all() as $error) {
				$error_str .= '<div style="margin-left:60px;font-size:90%;">- ' . $error . '</div>';
			}
			$failed = 'Validation failed. Please try again<br><br>' . $error_str;

			return Redirect::back()->with('STATUS_FAIL', $failed)->withInput();

		} else {

			$buyer_id = (int)$this->_createBuyer((int)Input::get('buyer_id'));
			$project_manager_id = (int)$this->_createProjectManager((int)Input::get('project_manager_id'));
			$end_user_id = (int)$this->_createEndUser((int)Input::get('end_user_id'));

			$project = new Project;
			$project->project_type 			= Input::get('project_type');
			$project->vendor_type 			= Input::get('vendor_type');
			$project->method 				= Input::get('method');
			$project->company 				= Input::get('company');
			$project->vendor_id 			= Input::get('vendor_id');
			$project->vendor_status 		= Input::get('vendor_status');
			$project->project_number 		= Input::get('project_number');
			$project->scope_of_work 		= Input::get('scope_of_work');
			$project->buyer_id 				= $buyer_id;
			$project->contract_period 		= Input::get('contract_period');
			$project->issuance_date 		= pickerToStamp(Input::get('issuance_date'));
			$project->estimate_date 		= pickerToStamp(Input::get('estimate_date'));
			$project->actual_date 			= pickerToStamp(Input::get('actual_date'));
			$project->project_manager_id 	= $project_manager_id;
			$project->end_user_id 			= $end_user_id;
			$project->save();

			// survey
			if ($buyer_id > 0) {
				$survey = new Survey;
				$survey->user_id = $buyer_id;
				$survey->project_id = $project->id;
				$survey->vendor_type = Input::get('vendor_type');
				$survey->user_type = 'buyer';
				$survey->save();
			}
			if ($project_manager_id > 0) {
				$survey = new Survey;
				$survey->user_id = $project_manager_id;
				$survey->project_id = $project->id;
				$survey->vendor_type = Input::get('vendor_type');
				$survey->user_type = 'project_manager';
				$survey->save();
			}
			if ($end_user_id > 0) {
				$survey = new Survey;
				$survey->user_id = $end_user_id;
				$survey->project_id = $project->id;
				$survey->vendor_type = Input::get('vendor_type');
				$survey->user_type = 'end_user';
				$survey->save();
			}

			$success = 'Record successfully inserted.';
			return Redirect::to(route('create.index', array(Input::get('project_type'), Input::get('project_id'))))->with('STATUS_OK', $success);
		}
	}

	public function GET_editIndex($type, $id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('create.edit');
		
		// params
		$vendor_types = getVendorTypes();
		$vendor_status = getVendorStatus();
		$methods = getMethods();
		$company = getCompanies();

		$project = Project::find($id);
		if(!$project) {
			Redirect::back()->with('STATUS_FAIL', 'Project not found.');
		}

		$params = array(
			'vendor_types' => $vendor_types,
			'vendor_status' => $vendor_status,
			'methods' => $methods,
			'company' => $company,
			'new' => $type,
			'project' => Project::find($id)
			);

		

		// css
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker-css', 'js/datepicker/datepicker.css');
		$theme->asset()->usePath()->add('typeahead-css', 'css/typeaheadjs.css');
		// post scripts
		// $theme->asset()->container('post-scripts')->usePath()->add('hotkeys', 'js/wysiwyg/jquery.hotkeys.js');
		// $theme->asset()->container('post-scripts')->usePath()->add('wysiwyg', 'js/wysiwyg/bootstrap-wysiwyg.js');
		// $theme->asset()->container('post-scripts')->usePath()->add('wysiwyg-demo', 'js/wysiwyg/demo.js');
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker', 'js/datepicker/bootstrap-datepicker.js');
		$theme->asset()->container('post-scripts')->usePath()->add('typeahead', 'js/typeahead/typeahead.js');
		// $theme->asset()->container('post-scripts')->usePath()->add('custom', 'js/custom.js');
		$theme->asset()->container('post-scripts')->usePath()->add('custom', 'js/custom.js?'.time());
		
		return $theme->scope('create.edit', $params)->render();
	}

	public function PUT_editIndex()
	{

		$validator = Validator::make(Input::all(), array(
			'project_type' 			=> 'required',
			'vendor_type' 			=> 'required',
			'method' 				=> 'required',
			'company' 				=> 'required',
			'vendor_id' 			=> 'required',
			'vendor_status' 		=> 'required',
			'project_number' 		=> 'required',
			'scope_of_work' 		=> 'required',
			'buyer_id' 				=> 'required_without_all:project_manager_id,end_user_id',
			// 'contract_period' 		=> 'required',
			'issuance_date' 		=> 'required|date_format:d-m-Y',
			// 'estimate_date' 		=> 'required|date_format:d-m-Y',
			'actual_date' 			=> 'required|date_format:d-m-Y',
			'project_manager_id' 	=> 'required_without_all:end_user_id,buyer_id',
			'end_user_id' 			=> 'required_without_all:project_manager_id,buyer_id',
			// 'gpd_head' 				=> 'required',
		));

		if ($validator->fails()) {
			$error_str = '';
			foreach ($validator->messages()->all() as $error) {
				$error_str .= '<div style="margin-left:60px;font-size:90%;">- ' . $error . '</div>';
			}
			$failed = 'Validation failed. Please try again<br><br>' . $error_str;

			return Redirect::back()->with('STATUS_FAIL', $failed)->withInput();

		} else {

			$buyer_id = (int)$this->_createBuyer((int)Input::get('buyer_id'));
			$project_manager_id = (int)$this->_createProjectManager((int)Input::get('project_manager_id'));
			$end_user_id = (int)$this->_createEndUser((int)Input::get('end_user_id'));

			$project = Project::find(Input::get('project_id'));
			$project->project_type 			= Input::get('project_type');
			$project->vendor_type 			= Input::get('vendor_type');
			$project->method 				= Input::get('method');
			$project->company 				= Input::get('company');
			$project->vendor_id 			= Input::get('vendor_id');
			$project->vendor_status 		= Input::get('vendor_status');
			$project->project_number 		= Input::get('project_number');
			$project->scope_of_work 		= Input::get('scope_of_work');
			$project->buyer_id 				= $buyer_id;
			$project->contract_period 		= Input::get('contract_period');
			$project->issuance_date 		= pickerToStamp(Input::get('issuance_date'));
			$project->estimate_date 		= pickerToStamp(Input::get('estimate_date'));
			$project->actual_date 			= pickerToStamp(Input::get('actual_date'));
			$project->project_manager_id 	= $project_manager_id;
			$project->end_user_id 			= $end_user_id;
			$project->save();

			// delete all survey of the project id
			$delete_survey = Survey::where('project_id', $project->id)
									->where('user_id', '<>', $buyer_id)
									->where('user_id', '<>', $project_manager_id)
									->where('user_id', '<>', $end_user_id)
									->delete();
			// survey
			if ($buyer_id > 0) {
				$chk_buyer = Survey::where('project_id', $project->id)
									->where('user_id', $buyer_id)
									->where('user_type', 'buyer')->count();
				if($chk_buyer == 0) {
					$survey = new Survey;
					$survey->user_id = $buyer_id;
					$survey->project_id = $project->id;
					$survey->vendor_type = Input::get('vendor_type');
					$survey->user_type = 'buyer';
					$survey->save();
				}
			}
			if ($project_manager_id > 0) {
				$chk_pm = Survey::where('project_id', $project->id)
									->where('user_id', $project_manager_id)
									->where('user_type', 'project_manager')->count();
				if($chk_pm == 0) {
					$survey = new Survey;
					$survey->user_id = $project_manager_id;
					$survey->project_id = $project->id;
					$survey->vendor_type = Input::get('vendor_type');
					$survey->user_type = 'project_manager';
					$survey->save();
				}
			}
			if ($end_user_id > 0) {
				$chk_enduser = Survey::where('project_id', $project->id)
									->where('user_id', $end_user_id)
									->where('user_type', 'end_user')->count();
				if($chk_enduser == 0) {
					$survey = new Survey;
					$survey->user_id = $end_user_id;
					$survey->project_id = $project->id;
					$survey->vendor_type = Input::get('vendor_type');
					$survey->user_type = 'end_user';
					$survey->save();
				}
			}

			$success = 'Record successfully updated.';
			return Redirect::back()->with('STATUS_OK', $success);
		}
	}

	//-- private functions
	private function _createBuyer($id)
	{
		$id = (int) $id;
		if($id <= 0 || !Input::has('buyer_name')) return 0;

		$buyer = Employee::find($id);
		try {
			$user = Sentry::findUserByCredentials(array(
		        'email' => $buyer->email
		    ));
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e) 
		{
			$user = $this->_createUser($buyer->email, $buyer->name, 'Buyer');
		}

		$group = Sentry::findGroupByName('Buyer');
		if (!$user->inGroup($group)) $user->addGroup($group);

		return $user->id;
	}

	private function _createProjectManager($id)
	{
		$id = (int) $id;
		if($id <= 0 || !Input::has('project_manager')) return 0;

		$employee = Employee::find($id);
		try {
			$user = Sentry::findUserByCredentials(array(
		        'email' => $employee->email
		    ));
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e) 
		{
			$user = $this->_createUser($employee->email, $employee->name, 'ProjectManager');
		}

		$group = Sentry::findGroupByName('ProjectManager');
		if (!$user->inGroup($group)) $user->addGroup($group);

		return $user->id;
	}

	private function _createEndUser($id)
	{
		$id = (int) $id;
		if($id <= 0 || !Input::has('end_user')) return 0;

		$employee = Employee::find($id);
		try {
			$user = Sentry::findUserByCredentials(array(
		        'email' => $employee->email
		    ));
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e) 
		{
			$user = $this->_createUser($employee->email, $employee->name, 'EndUser');
		}

		$group = Sentry::findGroupByName('EndUser');
		if (!$user->inGroup($group)) $user->addGroup($group);

		return $user->id;
	}

	private function _createUser($email, $name, $groupName)
	{
		$user = Sentry::createUser(array(
	        'email'    => strtolower($email),
	        'password' => 'Zaq!Xsw@',
	        'first_name' => ucwords(strtolower($name)),
	        'activated' => true,
	    ));
	    $group = Sentry::findGroupByName($groupName);
		$user->addGroup($group);

		return $user;
	}

}

?>