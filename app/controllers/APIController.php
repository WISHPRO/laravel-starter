<?php

/**
* RESTful class that return JSON String
*/
class APIController extends BaseController
{
	
	public function GET_vendors()
	{
		// Eloquent
		$vendor_objs = Vendor::active();

		$vendors = array();
		foreach ($vendor_objs as $key => $vendor) {
			//debug($vendor['name']);
			$vendors[] = array(
				'id' => $vendor['id'], 
				'name' => ucfirst(strtolower($vendor['name']))
				);
		}

		return Response::json($vendors);
	}

	public function GET_buyers()
	{
		// Eloquent
		$buyer_objs = Buyer::active();

		$buyers = array();
		foreach ($buyer_objs as $key => $buyer) {
			$buyers[] = array(
				'id' => $buyer['id'], 
				'name' => ucfirst(strtolower($buyer['name']))
				);
		}

		return Response::json($buyers);

		// $arrays = array("Andorra","United Arab Emirates","Afghanistan","Antigua and Barbuda","Anguilla","Albania","Armenia","Angola","Antarctica","Argentina","American Samoa","Austria","Australia","Aruba","Ã…land","Azerbaijan","Bosnia and Herzegovina","Barbados","Bangladesh","Belgium","Burkina Faso","Bulgaria","Bahrain","Burundi","Benin","Saint BarthÃ©lemy","Bermuda","Brunei","Bolivia","Bonaire","Brazil","Bahamas","Bhutan","Bouvet Island","Botswana","Belarus","Belize","Canada","Cocos [Keeling] Islands","Congo","Central African Republic","Republic of the Congo","Switzerland","Ivory Coast","Cook Islands","Chile","Cameroon","China","Colombia","Costa Rica","Cuba","Cape Verde","Curacao","Christmas Island","Cyprus","Czechia","Germany","Djibouti","Denmark","Dominica","Dominican Republic","Algeria","Ecuador","Estonia","Egypt","Western Sahara","Eritrea","Spain","Ethiopia","Finland","Fiji","Falkland Islands","Micronesia","Faroe Islands","France","Gabon","United Kingdom","Grenada","Georgia","French Guiana","Guernsey","Ghana","Gibraltar","Greenland","Gambia","Guinea","Guadeloupe","Equatorial Guinea","Greece","South Georgia and the South Sandwich Islands","Guatemala","Guam","Guinea-Bissau","Guyana","Hong Kong","Heard Island and McDonald Islands","Honduras","Croatia","Haiti","Hungary","Indonesia","Ireland","Israel","Isle of Man","India","British Indian Ocean Territory","Iraq","Iran","Iceland","Italy","Jersey","Jamaica","Jordan","Japan","Kenya","Kyrgyzstan","Cambodia","Kiribati","Comoros","Saint Kitts and Nevis","North Korea","South Korea","Kuwait","Cayman Islands","Kazakhstan","Laos","Lebanon","Saint Lucia","Liechtenstein","Sri Lanka","Liberia","Lesotho","Lithuania","Luxembourg","Latvia","Libya","Morocco","Monaco","Moldova","Montenegro","Saint Martin","Madagascar","Marshall Islands","Macedonia","Mali","Myanmar [Burma]","Mongolia","Macao","Northern Mariana Islands","Martinique","Mauritania","Montserrat","Malta","Mauritius","Maldives","Malawi","Mexico","Malaysia","Mozambique","Namibia","New Caledonia","Niger","Norfolk Island","Nigeria","Nicaragua","Netherlands","Norway","Nepal","Nauru","Niue","New Zealand","Oman","Panama","Peru","French Polynesia","Papua New Guinea","Philippines","Pakistan","Poland","Saint Pierre and Miquelon","Pitcairn Islands","Puerto Rico","Palestine","Portugal","Palau","Paraguay","Qatar","RÃ©union","Romania","Serbia","Russia","Rwanda","Saudi Arabia","Solomon Islands","Seychelles","Sudan","Sweden","Singapore","Saint Helena","Slovenia","Svalbard and Jan Mayen","Slovakia","Sierra Leone","San Marino","Senegal","Somalia","Suriname","South Sudan","SÃ£o TomÃ© and PrÃ­ncipe","El Salvador","Sint Maarten","Syria","Swaziland","Turks and Caicos Islands","Chad","French Southern Territories","Togo","Thailand","Tajikistan","Tokelau","East Timor","Turkmenistan","Tunisia","Tonga","Turkey","Trinidad and Tobago","Tuvalu","Taiwan","Tanzania","Ukraine","Uganda","U.S. Minor Outlying Islands","United States","Uruguay","Uzbekistan","Vatican City","Saint Vincent and the Grenadines","Venezuela","British Virgin Islands","U.S. Virgin Islands","Vietnam","Vanuatu","Wallis and Futuna","Samoa","Kosovo","Yemen","Mayotte","South Africa","Zambia","Zimbabwe");
		// return Response::json($arrays);
	}

	public function GET_employees()
	{
		$employee_objs = Employee::all();

		$employees = array();
		foreach ($employee_objs as $key => $employee) {
			$employees[] = array(
				'id' => $employee['id'], 
				// 'email' => $employee['email']
				'name' => $employee['name']
				);
		}

		return Response::json($employees);
	}

	public function GET_employees_email()
	{
		$emails = LDAP::employees_email();
		return Response::json($emails);
	}

	public function GET_update_db()
	{
		$counter = 0;
		$employees = LDAP::search_employees();
		foreach ($employees as $employee) {
			$exist = Employee::where('email', $employee['mail'])->get();
			if($exist->isEmpty()) {
				$email = new Employee;
				$email->name = $employee['name'];
				$email->email = $employee['mail'];
				$email->save();
				$counter++;
			}
		}
		return "OK. Total $counter email(s) inserted.";
	}


	/**
	Migration from old db
	---
		SET FOREIGN_KEY_CHECKS=0;
		TRUNCATE projects;
		TRUNCATE surveys;
		SET FOREIGN_KEY_CHECKS=1;
	*/
	public function GET_migration()
	{
		$vpadb = VpaDb::all();
		$i = 0;
		foreach ($vpadb as $key => $vpa) {
			$project_type 		= $vpa->vpa_type;
			$vendor_type 		= $vpa->vpa_type1;
			$company 			= $vpa->vpa_opco;
			$vendor_id 			= $vpa->vpa_vendor;
			$project_number 	= $vpa->vpa_po;
			$scope_of_work 		= $vpa->vpa_poscopeW; 
			$contract_period 	= $vpa->vpa_pocontNo;
			$issuance_date 		= $vpa->vpa_postartD;
			$estimate_date 		= $vpa->vpa_poestimateD;
			$actual_date 		= $vpa->vpa_podeliveryD;
			$status 			= 0;

			$vpa_method = Method::where('method', $vpa->vpa_method)->first();
			if($vpa_method) {
				$vpa_method_id = $vpa_method->id;
			} else {
				$vpa_method_id = 4;
			}
			$method 			= $vpa_method_id;

			$vendor_status = VendorStatus::where('status', $vpa->vpa_vstatus)->first();
			if($vendor_status) {
				$vendor_status_id = $vendor_status->id;
			} else {
				$vendor_status_id = 4;
			}
			$vendor_status 		= $vendor_status_id;

			$buyer_id 			= (int)$this->_createBuyer((int)$vpa->vpa_buyer);
			$project_manager_id = (int)$this->_createProjectManager($vpa->resp_email3);
			$end_user_id 		= (int)$this->_createEndUser($vpa->resp_email2);


			$project = new Project;
			$project->project_type 			= $project_type;
			$project->vendor_type 			= $vendor_type;
			$project->method 				= $method;
			$project->company 				= $company;
			$project->vendor_status 		= $vendor_status;
			$project->vendor_id 			= $vendor_id;
			$project->project_number 		= $project_number;
			$project->scope_of_work 		= $scope_of_work;
			$project->buyer_id 				= $buyer_id;
			$project->contract_period 		= $contract_period;
			$project->issuance_date 		= $issuance_date;
			$project->estimate_date 		= $estimate_date;
			$project->actual_date 			= $actual_date;
			$project->project_manager_id 	= $project_manager_id;
			$project->end_user_id 			= $end_user_id;
			$project->status 				= $status;
			$project->save();

			// survey
			if ($buyer_id > 0) {
				$survey = new Survey;
				$survey->user_id = $buyer_id;
				$survey->project_id = $project->id;
				$survey->vendor_type = $vendor_type;
				$survey->user_type = 'buyer';
				$survey->save();
			}
			if ($project_manager_id > 0) {
				$survey = new Survey;
				$survey->user_id = $project_manager_id;
				$survey->project_id = $project->id;
				$survey->vendor_type = $vendor_type;
				$survey->user_type = 'project_manager';
				$survey->save();
			}
			if ($end_user_id > 0) {
				$survey = new Survey;
				$survey->user_id = $end_user_id;
				$survey->project_id = $project->id;
				$survey->vendor_type = $vendor_type;
				$survey->user_type = 'end_user';
				$survey->save();
			}

			$i++;
		}

		$success = $i . ' Records successfully inserted.';
		echo $success;
	}
	

	public function GET_migrationVendor()
	{
		$vpadb = VpaDbVendor::all();
		$i = 0;
		foreach ($vpadb as $key => $vpa) {
			try {
				if(strlen($vpa->vendorName) > 1) {
					$vendor = new Vendor;
					$vendor->id 		= (int) $vpa->vendorID;
					$vendor->name 		= $vpa->vendorName;
					$vendor->contact 	= $vpa->vendorContactP;
					$vendor->status 	= $vpa->vendoract;
					$vendor->save();
					$i++;
				}
			} catch (Exception $e) {
				echo 'duplicate: ' . $vpa->vendorName . '<br>';
			}
		}
		$success = $i . ' Records successfully inserted.';
		echo $success;
	}

	public function GET_migrationBuyer()
	{
		$vpadb = VpaDbBuyer::all();
		$i = 0;
		foreach ($vpadb as $key => $vpa) {
			try {
				if(strlen($vpa->buyerName) > 1) {
					$buyer = new Buyer;
					$buyer->id			= (int) $vpa->buyerID;
					$buyer->name 		= ucwords(strtolower($vpa->buyerName));
					$buyer->email 		= $vpa->buyer_email;
					$buyer->status 		= $vpa->buyer_act;
					$buyer->save();
					$i++;
				}
			} catch (Exception $e) {
				echo 'duplicate: ' . $vpa->buyerName . '<br>';
			}
		}
		$success = $i . ' Records successfully inserted.';
		echo $success;
	}

	//-- private functions
	private function _createBuyer($id)
	{
		$id = (int) $id;
		if($id <= 0) return;

		$buyer = Buyer::find($id);
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

	private function _createProjectManager($email)
	{
		$employee = Employee::where('email', $email)->first();
		if($employee) {
			$id = $employee->id;
		} else {
			return;
		}

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

	private function _createEndUser($email)
	{
		$employee = Employee::where('email', $email)->first();
		if($employee) {
			$id = $employee->id;
		} else {
			return;
		}

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

