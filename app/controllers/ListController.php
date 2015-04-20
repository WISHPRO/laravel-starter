<?php

class ListController extends BaseController {

	private $vendor_types;
	private $company;

	public function __construct()
	{
		$this->vendor_types = getVendorTypes();
		$this->company = getCompanies();
	}

	public function GET_display($id)
	{
		$theme = Theme::uses('notebook')->layout('popup');
		$theme->setMenu('list.display');

		$project = Project::find($id);
		$params = array('project' => $project);
		
		return $theme->scope('list.display', $params)->render();
	}

	public function GET_vendor($id)
	{
		$theme = Theme::uses('notebook')->layout('popup');
		$theme->setMenu('list.vendor');

		$vendor = Vendor::find($id);
		$params = array('vendor' => $vendor, 'vendor_types' => $this->vendor_types);
		
		return $theme->scope('list.vendor', $params)->render();
	}

	public function GET_score($id)
	{
		$theme = Theme::uses('notebook')->layout('popup');
		$theme->setMenu('list.score');

		$vendor = Vendor::find($id);
		$params = array('vendor' => $vendor, 'vendor_types' => $this->vendor_types);
		
		return $theme->scope('list.score', $params)->render();
	}

	public function GET_consultant()
	{
		return $this->_showProjectList(CONSULTANT);
	}

	public function GET_consultantDetails($project_id = 0)
	{
		return $this->_showQuestionnaire($project_id, CONSULTANT);
	}

	public function POST_consultant()
	{
		$questionnaire = new Questionnaire;
		$questionnaire->user_id = Sentry::getUser()->id;
		$questionnaire->project_id = Input::get('project_id');;
		$questionnaire->vendor_name = Input::get('vendor_name');
		$questionnaire->po_number = Input::get('po_number');
		$questionnaire->scope = Input::get('scope');
		$questionnaire->remark = Input::get('remark');
		$questionnaire->staff_id = Input::get('staff_id');
		$questionnaire->staff_name = Input::get('staff_name');
		$questionnaire->department = Input::get('department');
		$questionnaire->designation = Input::get('designation');
		$questionnaire->save();

		$msg = 'Thank you, survey successfully submitted.';
		return Redirect::back()->with('STATUS_OK', $msg);
	}

	public function DELETE_consultant()
	{
		$project = Project::find($id);
		$project->delete();
		$msg = 'Selected project successfully deleted.';
		return Redirect::to(route('list.consultant'))->with('STATUS_OK', $msg);
	}



	public function GET_contractor()
	{
		return $this->_showProjectList(CONTRACTOR);
	}

	public function GET_contractorDetails($project_id = 0)
	{
		return $this->_showQuestionnaire($project_id, CONTRACTOR);
	}

	public function POST_contractor()
	{
		
	}

	public function DELETE_contractor()
	{
		$project = Project::find($id);
		$project->delete();
		$msg = 'Selected project successfully deleted.';
		return Redirect::to(route('list.contractor'))->with('STATUS_OK', $msg);
	}




	public function GET_supplier()
	{
		return $this->_showProjectList(SUPPLIER);
	}

	public function GET_supplierDetails($project_id = 0)
	{
		return $this->_showQuestionnaire($project_id, SUPPLIER);
	}

	public function POST_supplier()
	{
		
	}

	public function DELETE_supplier($id)
	{
		$project = Project::find($id);
		$project->delete();
		$msg = 'Selected project successfully deleted.';
		return Redirect::to(route('list.supplier'))->with('STATUS_OK', $msg);
	}




	// private methods
	private function _showProjectList($type)
	{
		if($type == CONSULTANT) {
			$str = 'consultant';
		} else if($type == CONTRACTOR) {
			$str = 'contractor';
		} else if($type == SUPPLIER) {
			$str = 'supplier';
		}

		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('list.'.$str);

		$theme->asset()->container('post-styles')->usePath()->add('dataTables.bootstrap', 'js/datatables/datatables.css');
		$theme->asset()->container('post-scripts')->usePath()->add('jquery_dataTables', 'js/datatables/jquery.dataTables.min.js');
		$theme->asset()->container('post-scripts')->usePath()->add('dataTables_bootstrap', 'js/datatables/dataTables.bootstrap.js');
		$theme->asset()->container('post-scripts')->usePath()->add('dataTables_custom', 'js/datatables/custom.js');
		// $theme->asset()->container('post-scripts')->usePath()->add('jquery_dataTables', 'js/datatables/jquery.dataTables.min.js?'.time());
		// $theme->asset()->container('post-scripts')->usePath()->add('dataTables_bootstrap', 'js/datatables/dataTables.bootstrap.js?'.time());
		// $theme->asset()->container('post-scripts')->usePath()->add('dataTables_custom', 'js/datatables/custom.js?'.time());

		$projects = Project::where('vendor_type', $type)
							->orderBy('actual_date', 'asc')
							->get();
		$params = array('type' => ucwords($str), 'projects'=>$projects, 'vendor_types' => $this->vendor_types, 'company'=>$this->company);
		return $theme->scope('list.projects', $params)->render();
	}


	private function _showQuestionnaire($project_id, $type)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('list.'.strtolower($this->vendor_types[$type]));

		if($project_id > 0) {
			$project = Project::find($project_id);
		} else if (Input::has('po_number')) {
			$project = Project::where('project_number', Input::get('po_number'))
							  ->where('vendor_type', $type)
							  ->first();
			if($project) {
				$project_id = $project->id;
			} else {
				return Redirect::back()->with('STATUS_FAIL', 'Project number not found.');
			}
		}

		if ($project_id > 0) {
			$vendor = Vendor::find($project->vendor_id);
			$questionnaires = Questionnaire::where('type', $type)->orderBy('index')->get();
			$surveys = Survey::where('project_id', $project_id)
					 		 ->where('vendor_type', $type)->get();
			$marks = array();
			$assessors = array();
			$i = 0;
			foreach ($surveys as $survey) {
				// debug($survey->assessor);
				$assessors[$i]['user'] = $survey->assessor->first_name;
				$assessors[$i]['email'] = $survey->assessor->email;
				$assessors[$i]['type'] = $survey->user_type;
				$assessors[$i]['status'] = $survey->status;
				$i++;
				foreach ($survey->answers as $answer) {
					if(!isset($marks[$answer->questionnaire_id][1])) $marks[$answer->questionnaire_id][1] = 0;
					if(!isset($marks[$answer->questionnaire_id][2])) $marks[$answer->questionnaire_id][2] = 0;
					if(!isset($marks[$answer->questionnaire_id][3])) $marks[$answer->questionnaire_id][3] = 0;
					$marks[$answer->questionnaire_id][$answer->mark] += 1;
				}
			}
			
			$params = array(
				'type' => strtolower($this->vendor_types[$type]), 
				'project' => $project, 
				'vendor' => $vendor,
				'user' => Sentry::getUser(),
				'questionnaires' => $questionnaires,
				'marks' => $marks,
				'assessors' => $assessors,
				'assessor_status' => array(
					'<span class="label bg-warning">New</span>', 
					'<span class="label bg-success">Done</span>'));
			return $theme->scope('list.questionnaire', $params)->render();
		} else {
			$params = array('type' => strtolower($this->vendor_types[$type]), 'selected' => 2, 'vendor_types' => $this->vendor_types, 'project_id' => $project_id);
			return $theme->scope('list.search', $params)->render();
		}
	}

}




