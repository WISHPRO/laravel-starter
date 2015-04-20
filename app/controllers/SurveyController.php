<?php

class SurveyController extends BaseController {

	private $vendor_types;
	private $company;
	private $today;

	public function __construct()
	{
		$this->vendor_types = getVendorTypes();
		$this->company = getCompanies();
		$this->today = new DateTime('today');
	}

	public function GET_index()
	{
		return $this->_getSurveyList(0);
	}

	public function GET_done()
	{
		return $this->_getSurveyList(1);
	}

	// public function GET_done()
	// {
	// 	return $this->_getSurveyList(2);
	// }

	public function GET_display($id)
	{
		$theme = Theme::uses('notebook')->layout('popup');
		$theme->setMenu('survey.display');

		$project = Project::find($id);
		$user = Sentry::getUser();
		$profile_incomplete = false;
		if($user->employee_id <= 0 || empty($user->department) || empty($user->designation)) {
			$profile_incomplete = true;
		}
		$params = array(
			'project' => $project,
			'profile_incomplete' => $profile_incomplete
			);
		
		return $theme->scope('survey.display', $params)->render();
	}



	public function GET_consultant($project_id = 0)
	{
		return $this->_showQuestionnaire($project_id, CONSULTANT);
	}

	public function POST_consultant()
	{
		return $this->_submitQuestionnaire(CONSULTANT);
	}



	public function GET_contractor($project_id = 0)
	{
		return $this->_showQuestionnaire($project_id, CONTRACTOR);
	}

	public function POST_contractor()
	{
		return $this->_submitQuestionnaire(CONTRACTOR);
	}


	public function GET_supplier($project_id = 0)
	{
		return $this->_showQuestionnaire($project_id, SUPPLIER);
	}

	public function POST_supplier()
	{
		return $this->_submitQuestionnaire(SUPPLIER);
	}



	public function GET_updateUserForm()
	{
		$theme = Theme::uses('notebook')->layout('survey');
		$theme->setMenu('survey.setting');

		$user = Sentry::getUser();

		$params = array('user' => $user);
		return $theme->scope('survey.setting', $params)->render();
	}

	public function PUT_updateUser()
	{
		$validator = Validator::make(Input::all(), array(
			'full_name' 				=> 'required',
			'employee_id'				=> 'required|integer|digits:8',
			'department' 				=> 'required',
			'designation' 				=> 'required'
		));

		if ($validator->fails()) {
			$error_str = '';
			foreach ($validator->messages()->all() as $error) {
				$error_str .= '<div style="margin-left:60px;font-size:90%;">- ' . $error . '</div>';
			}
			$failed = 'Validation failed. Please try again<br><br>' . $error_str;
			return Redirect::back()->with('STATUS_FAIL', $failed)->withInput();
		}

		try
		{
			$user = Sentry::getUser();
			// $user->email = Input::get('email');
		    $user->first_name = Input::get('full_name');
		    $user->employee_id = Input::get('employee_id');
		    $user->department = Input::get('department');
		    $user->designation = Input::get('designation');
		    if(Input::has('password')) $user->password = Input::get('password');

			if ($user->save()) {
		        $success = 'User information successfully updated';
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
			return Redirect::back()->with('STATUS_FAIL', $failed);
		} else if (!empty($success)) {
			return Redirect::back()->with('STATUS_OK', $success);
		}
	}



	// Private functions
	private function _validateQuestionnaire() 
	{
		$validator = Validator::make(Input::all(), array(
			'questions' 	=> 'required|array|min:'.Input::get('total_questions'),
			'project_id'	=> 'required|integer'
		));

		if ($validator->fails()) {
			$error_str = '';
			foreach ($validator->messages()->all() as $error) {
				$error_str .= '<div style="margin-left:60px;font-size:90%;">- ' . $error . '</div>';
			}
			$failed = 'Validation failed. Please try again<br><br>' . $error_str;
			return Redirect::back()->with('STATUS_FAIL', $failed)->withInput();
		}
	}

	private function _accessmentStatus($type, $project_id)
	{
		$chk = Survey::where('user_id', Sentry::getUser()->id)
					 ->where('project_id', $project_id)
					 ->where('vendor_type', $type)
					 ->first();
		$status = false;
		if($chk->status > 0) {
			$status = true;
		// 	$msg = 'You\'ve already responded to this questionnaire.';
		// 	return Redirect::to(route('survey.'.strtolower($this->vendor_types[$type]), $project_id))->with('STATUS_FAIL', $msg)->withInput();
		}
		return $status;
	}

	private function _submitQuestionnaire($type)
	{
		$this->_validateQuestionnaire();
		
		$chk = $this->_accessmentStatus($type, Input::get('project_id'));
		if ($chk) {
			return Redirect::back();
		}

		if(Input::has('delay') && Input::has('delay_date') && Input::has('delay_reason')) {
			$delay_project = Project::find(Input::get('project_id'));
			$delay_project->delay = 1;
			$delay_project->delay_date = $delay_project->actual_date;
			$delay_project->actual_date = pickerToStamp(Input::get('delay_date'));
			$delay_project->delay_user = Sentry::getUser()->id;
			$delay_project->delay_reason = Input::get('delay_reason');
			$delay_project->save();
			
			$surveys = Survey::where('project_id', Input::get('project_id'))
							 ->where('vendor_type', $type)->get();
			foreach ($surveys as $survey) {
				$survey->remark = '';
				$survey->status = 0;
				$survey->sent = '0000-00-00 00:00:00';
				$survey->save();

				$answers = Answer::where('survey_id', $survey->id)->delete();
			}

			$msg = 'Done. This project survey has been postponed to `'.Input::get('delay_date').'`.';
			return Redirect::to(route('survey'))->with('STATUS_OK', $msg)->withInput();

		} else {

			$survey = Survey::where('user_id', Sentry::getUser()->id)
							->where('project_id', Input::get('project_id'))
							->where('vendor_type', $type)->first();
			$survey->remark = Input::get('remark');
			$survey->status = 1;
			$survey->sent = date('Y-m-d H:i:s');
			$survey->save();

			foreach (Input::get('questions') as $key => $mark) {
				$chk = Answer::where('user_id', Sentry::getUser()->id)
								->where('survey_id', $survey->id)
								->where('questionnaire_id', $key)->count();
				if($chk == 0) {
					$answer = new Answer;
					$answer->user_id = Sentry::getUser()->id;
					$answer->survey_id = $survey->id;
					$answer->questionnaire_id = $key;
					$answer->mark = $mark;
					$answer->save();
				}
			}

			$msg = 'Thank you, survey successfully submitted.';
			return Redirect::back()->with('STATUS_OK', $msg)->withInput();
		}
	}

	private function _showQuestionnaire($project_id, $type)
	{
		$theme = Theme::uses('notebook')->layout('survey');
		$theme->setMenu('survey.'.$this->vendor_types[$type]);

		$theme->asset()->usePath()->add('datepicker-css', 'js/datepicker/datepicker.css');
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker', 'js/datepicker/bootstrap-datepicker.js');
		$theme->asset()->container('post-scripts')->usePath()->add('survey', 'js/survey.js');

		$project = Project::where('id', $project_id)->where(function($query){
			$user = Sentry::getUser();
			$query->orWhere('buyer_id', $user->id)
				  ->orWhere('project_manager_id', $user->id)
				  ->orWhere('end_user_id', $user->id);
		})->first();

		if ($project) {
			$project_id = $project->id;
		} else {
			$project_id = 0;
		}

		if ($project_id > 0) {
			$vendor = Vendor::find($project->vendor_id);

			$me = Sentry::getUser();
			$roles = array();
			if($me->id == $project->buyer_id) $roles[] = 'Buyer';
			if($me->id == $project->project_manager_id) $roles[] = 'Project Manager';
			if($me->id == $project->end_user_id) $roles[] = 'End User';

			if($type == SUPPLIER) {
				if($me->id == $project->buyer_id) {
					$questionnaires = Questionnaire::where('type', $type)
											   ->where('buyer_only', 1)
											   ->orderBy('index')->get();
				} else {
					$questionnaires = Questionnaire::where('type', $type)
											   ->where('buyer_only', 0)
											   ->orderBy('index')->get();
				}
			} else {
				$questionnaires = Questionnaire::where('type', $type)->orderBy('index')->get();
			}
			$survey = Survey::where('user_id', Sentry::getUser()->id)
							->where('project_id', $project_id)
							->where('vendor_type', $type)->first();
			// debug($survey);
			$marks = array();
			foreach ($survey->answers as $key => $answer) {
				$marks[$answer->questionnaire_id][1] = false;
				$marks[$answer->questionnaire_id][2] = false;
				$marks[$answer->questionnaire_id][3] = false;
				$marks[$answer->questionnaire_id][$answer->mark] = true;
			}
			$params = array(
				'type' => strtolower($this->vendor_types[$type]), 
				'project' => $project, 
				'vendor' => $vendor,
				'user' => Sentry::getUser(),
				'questionnaires' => $questionnaires,
				'marks' => $marks,
				'survey' => $survey,
				'responded' => $this->_accessmentStatus($type, $project_id));
			return $theme->scope('survey.questionnaire', $params)->render();
		} else {
			return Redirect::to(route('survey'))->with('STATUS_FAIL', 'You have no access to this questionnaire.');
		}
	}

	private function _getSurveyList($type)
	{
		$status_types = array('New', 'Done');

		$theme = Theme::uses('notebook')->layout('survey');
		$theme->setMenu('survey.'.strtolower($status_types[$type]));

		$pids = array('');
		$surveys = Survey::where('user_id', Sentry::getUser()->id)
						 ->where('status', $type)->get();
		foreach ($surveys as $key => $survey) {
			$pids[] = $survey->project_id;
		}

		$projects = Project::whereIn('id', $pids)
							->where('actual_date', '<=', $this->today)
							// ->where(function($query){
							// 	$query->orWhere(function($query1){
							// 			$query1->where('delay', 0)
							// 				   ->where('actual_date', '<=', $this->today);
							// 		  })
							// 		  ->orWhere(function($query2){
							// 		  	$query2->where('delay', 1)
							// 		  		   ->where('delay_date', '<=', $this->today);
							// 		  });
							// })
							->where(function($query){
								$user = Sentry::getUser();
								$query->orWhere('buyer_id', $user->id)
									  ->orWhere('project_manager_id', $user->id)
									  ->orWhere('end_user_id', $user->id);
							})->orderBy('actual_date', 'asc')->get();

		$user = Sentry::getUser();
		$profile_incomplete = false;
		if($user->employee_id <= 0 || empty($user->department) || empty($user->designation)) {
			$profile_incomplete = true;
		}
		$params = array(
			'type' => '('.$status_types[$type].')', 
			'projects' => $projects, 
			'surveys' => $surveys,
			'vendor_types' => $this->vendor_types, 
			'company' => $this->company, 
			'profile_incomplete' => $profile_incomplete
			);

		return $theme->scope('survey.index', $params)->render();
	}

}