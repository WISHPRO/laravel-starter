<?php

class SearchController extends BaseController {

	private $vendor_types;
	private $vendor_statuses;
	private $company;
	private $methods;
	private $search_fields;
	private $defaults;

	public function __construct()
	{
		$this->vendor_types = getVendorTypes();
		$this->vendor_statuses = getVendorStatus();
		$this->company = getCompanies();
		$this->methods = getMethods();
		$this->search_fields = array(
			'project_type' 		=> 'Project Type',
			'vendor_type' 		=> 'Vendor Type',
			'method' 			=> 'Method',
			'company' 			=> 'Company',
			'vendor_id' 		=> 'Vendor Name',
			'vendor_status' 	=> 'Vendor Status',
			'project_number' 	=> 'P.O/W.O/LOA No.',
			'scope_of_work' 	=> 'Scope of Work',
			'issuance_date' 	=> 'Issuance Date',
			'actual_date' 		=> 'Actual Date',
			'buyer_id' 			=> 'Buyer Name',
			'project_manager_id'=> 'Project Manager',
			'end_user_id' 		=> 'End User',
			'status' 			=> 'Project Status'
			);
		$this->defaults = array(
			'project_number',
			'vendor_id',
			'buyer_id',
			// 'project_manager_id',
			// 'end_user_id',
			'status'
			);
		array_unshift($this->vendor_types, "");
		array_unshift($this->vendor_statuses, "");
		array_unshift($this->company, "");
		array_unshift($this->methods, "");
	}

	public function GET_search()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('search.search');
		// css
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker-css', 'js/datepicker/datepicker.css');
		$theme->asset()->usePath()->add('typeahead-css', 'css/typeaheadjs.css');
		// post scripts
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker', 'js/datepicker/bootstrap-datepicker.js');
		$theme->asset()->container('post-scripts')->usePath()->add('typeahead', 'js/typeahead/typeahead.js');
		$theme->asset()->container('post-scripts')->usePath()->add('search', 'js/keyword_search.js?'.time());
		$theme->asset()->container('post-scripts')->usePath()->add('custom', 'js/custom.js?'.time());

		$params = array(
			'search_fields' => $this->search_fields, 
			'defaults' => $this->defaults,
			'project_types' => array(''=>'', 'CAPEX'=>'CAPEX', 'OPEX'=>'OPEX'),
			'vendor_types' => $this->vendor_types,
			'vendor_status' => $this->vendor_statuses,
			'company' => $this->company,
			'methods' => $this->methods,
			'statuses' => array(''=>'', 'Completed'=>'Completed', 'Delayed'=>'Delayed')
			);
		return $theme->scope('search.search', $params)->render();
	}

	public function POST_search()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('search.search');
		// css
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker-css', 'js/datepicker/datepicker.css');
		$theme->asset()->usePath()->add('typeahead-css', 'css/typeaheadjs.css');
		// post scripts
		$theme->asset()->container('post-scripts')->usePath()->add('datepicker', 'js/datepicker/bootstrap-datepicker.js');
		$theme->asset()->container('post-scripts')->usePath()->add('typeahead', 'js/typeahead/typeahead.js');
		$theme->asset()->container('post-scripts')->usePath()->add('search', 'js/keyword_search.js?'.time());
		$theme->asset()->container('post-scripts')->usePath()->add('custom', 'js/custom.js?'.time());

		$hiddens = array(
			'vendor_name' => 'vendor_id',
			'buyer_name' => 'buyer_id',
			'project_manager' => 'project_manager_id',
			'end_user' => 'end_user_id'
			);

		$array = array();
		$new_defaults = array();
		foreach ($this->search_fields as $key => $field) {
			if (Input::has($key)) {
				$tmp = Input::get($key);
				if (in_array($key, $hiddens)) {
					$k = array_search($key, $hiddens);
					if(!Input::has($k)) $tmp = 0;
				}

				if ((is_numeric($tmp) && $tmp > 0) || (!is_numeric($tmp) && strlen($tmp) > 0)) {
					// debug($key . '->' . $tmp);
					$array[$key] = $tmp;
					$new_defaults[] = $key;
				}
			}
		}

		if (count($array) > 0) {
			$projects = Project::where(function($query) use ($array) {
				foreach ($array as $key => $value) {
					if ($key == 'scope_of_work') {
						$query->where($key, 'like', "%$value%");
					} else if ($key == 'issuance_date' || $key == 'actual_date') {
						$query->where($key, stringToDate($value));
					} else if ($key == 'status' && $value == 'Delayed') {
						$query->where('delay', 1);
					} else if ($key == 'status' && $value == 'Completed') {
						$pids = Analytic::completedProjects();
						$query->whereIn('id', $pids);
					} else if ($key == 'buyer_id' || $key == 'project_manager_id' || $key == 'end_user_id') {
						$emp = Employee::find($value);
						$user = Sentry::findUserByLogin($emp->email);
						$query->where($key, $user->id);
					} else {
						$query->where($key, $value);
					}
				}
			})->get();
		} else {
			$projects = Project::where(0);
		}

		$params = array(
			'search_fields' => $this->search_fields, 
			'defaults' => $new_defaults,
			'project_types' => array(''=>'', 'CAPEX'=>'CAPEX', 'OPEX'=>'OPEX'),
			'vendor_types' => $this->vendor_types,
			'vendor_status' => $this->vendor_statuses,
			'company' => $this->company,
			'methods' => $this->methods,
			'statuses' => array(''=>'', 'Completed'=>'Completed', 'Delayed'=>'Delayed'),
			'projects' => $projects
			);
		return $theme->scope('search.result', $params)->render();
	}


}




