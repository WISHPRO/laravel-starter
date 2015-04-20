<?php

class ConfigController extends BaseController {

	// Consultant
	public function GET_consultant()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.consultant');

		$questionnaires = Questionnaire::where('type', CONSULTANT)->orderBy('index')->get();

		$update = new Questionnaire;
		$params = array('questionnaires' => $questionnaires, 'update' => $update, 'id' => '');
		return $theme->scope('config.consultant', $params)->render();
	}

	public function POST_consultant()
	{
		if (Input::has('criteria')) {
			$questionnaire = new Questionnaire;
			$questionnaire->index = Input::get('index');
			$questionnaire->criteria = Input::get('criteria');
			$questionnaire->type = CONSULTANT; //-- 0=consultant, 1=contractor, 2=supplier
			$questionnaire->status = 1; //-- 1=active, 0-inactive
			$questionnaire->buyer_only = 0;
			$questionnaire->save();

			$msg = 'New criteria successfully added.';
			return Redirect::back()->with('STATUS_OK', $msg);
		} else {
			$msg = 'Criteria cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function GET_consultantUpdate($id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.consultant');

		$questionnaires = Questionnaire::where('type', CONSULTANT)->orderBy('index')->get();

		$update = Questionnaire::find($id);

		$params = array('questionnaires' => $questionnaires, 'update' => $update, 'id' => $id);
		return $theme->scope('config.consultant_edit', $params)->render();
	}

	public function PUT_consultant($id)
	{
		if (Input::has('criteria') && $id) {
			$questionnaire = Questionnaire::find($id);
			$questionnaire->index = Input::get('index');
			$questionnaire->criteria = Input::get('criteria');
			$questionnaire->type = CONSULTANT; //-- 1=consultant, 2=contractor, 3=supplier
			$questionnaire->status = 1; //-- 1=active, 0-inactive
			$questionnaire->buyer_only = 0;
			$questionnaire->save();

			$msg = 'New criteria successfully updated.';
			return Redirect::to(route('config.consultant'))->with('STATUS_OK', $msg);
		} else {
			$msg = 'Criteria cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function DELETE_consultant($id)
	{
		if ($id) {
			$questionnaire = Questionnaire::find($id);
			$questionnaire->delete();
			$msg = 'Selected question successfully deleted.';
			return Redirect::to(route('config.consultant'))->with('STATUS_OK', $msg);
		}else {
			$msg = 'Question not found.';
			return Redirect::to(route('config.consultant'))->with('STATUS_FAIL', $msg);
		}
	}



	// Contractor
	public function GET_contractor()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.contractor');

		$questionnaires = Questionnaire::where('type', CONTRACTOR)->orderBy('index')->get();

		$update = new Questionnaire;
		$params = array('questionnaires' => $questionnaires, 'update' => $update, 'id' => '');
		return $theme->scope('config.contractor', $params)->render();
	}

	public function POST_contractor()
	{
		if (Input::has('criteria')) {
			$questionnaire = new Questionnaire;
			$questionnaire->index = Input::get('index');
			$questionnaire->criteria = Input::get('criteria');
			$questionnaire->type = CONTRACTOR; //-- 0=consultant, 1=contractor, 2=supplier
			$questionnaire->status = 1; //-- 1=active, 0-inactive
			$questionnaire->buyer_only = 0;
			$questionnaire->save();

			$msg = 'New criteria successfully added.';
			return Redirect::back()->with('STATUS_OK', $msg);
		} else {
			$msg = 'Criteria cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function GET_contractorUpdate($id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.contractor');

		$questionnaires = Questionnaire::where('type', CONTRACTOR)->orderBy('index')->get();

		$update = Questionnaire::find($id);

		$params = array('questionnaires' => $questionnaires, 'update' => $update, 'id' => $id);
		return $theme->scope('config.contractor_edit', $params)->render();
	}

	public function PUT_contractor($id)
	{
		if (Input::has('criteria') && $id) {
			$questionnaire = Questionnaire::find($id);
			$questionnaire->index = Input::get('index');
			$questionnaire->criteria = Input::get('criteria');
			$questionnaire->type = CONTRACTOR; //-- 0=consultant, 1=contractor, 2=supplier
			$questionnaire->status = 1; //-- 1=active, 0-inactive
			$questionnaire->buyer_only = 0;
			$questionnaire->save();

			$msg = 'New criteria successfully updated.';
			return Redirect::to(route('config.contractor'))->with('STATUS_OK', $msg);
		} else {
			$msg = 'Criteria cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function DELETE_contractor($id)
	{
		if ($id) {
			$questionnaire = Questionnaire::find($id);
			$questionnaire->delete();
			$msg = 'Selected question successfully deleted.';
			return Redirect::to(route('config.contractor'))->with('STATUS_OK', $msg);
		}else {
			$msg = 'Question not found.';
			return Redirect::to(route('config.contractor'))->with('STATUS_FAIL', $msg);
		}
	}




	// Supplier
	public function GET_supplier()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.supplier');

		$questionnaires = Questionnaire::where('type', SUPPLIER)->orderBy('index')->get();

		$update = new Questionnaire;
		$params = array('questionnaires' => $questionnaires, 'update' => $update, 'id' => '');
		return $theme->scope('config.supplier', $params)->render();
	}

	public function POST_supplier()
	{
		if (Input::has('criteria')) {
			$questionnaire = new Questionnaire;
			$questionnaire->index = Input::get('index');
			$questionnaire->criteria = Input::get('criteria');
			$questionnaire->type = SUPPLIER; //-- 0=consultant, 1=contractor, 2=supplier
			$questionnaire->status = 1; //-- 1=active, 0-inactive
			$questionnaire->buyer_only = (int)Input::get('buyer_only');
			$questionnaire->save();

			$msg = 'New criteria successfully added.';
			return Redirect::back()->with('STATUS_OK', $msg);
		} else {
			$msg = 'Criteria cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function GET_supplierUpdate($id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.supplier');

		$questionnaires = Questionnaire::where('type', SUPPLIER)->orderBy('index')->get();

		$update = Questionnaire::find($id);
		$params = array('questionnaires' => $questionnaires, 'update' => $update, 'id' => $id);
		return $theme->scope('config.supplier_edit', $params)->render();
	}

	public function PUT_supplier($id)
	{
		if (Input::has('criteria') && $id) {
			$questionnaire = Questionnaire::find($id);
			$questionnaire->index = Input::get('index');
			$questionnaire->criteria = Input::get('criteria');
			$questionnaire->type = SUPPLIER; //-- 0=consultant, 1=contractor, 2=supplier
			$questionnaire->status = 1; //-- 1=active, 0-inactive
			$questionnaire->buyer_only = (int)Input::get('buyer_only');
			$questionnaire->save();

			$msg = 'New criteria successfully updated.';
			return Redirect::to(route('config.supplier'))->with('STATUS_OK', $msg);
		} else {
			$msg = 'Criteria cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function DELETE_supplier($id)
	{
		if ($id) {
			$questionnaire = Questionnaire::find($id);
			$questionnaire->delete();
			$msg = 'Selected question successfully deleted.';
			return Redirect::to(route('config.supplier'))->with('STATUS_OK', $msg);
		}else {
			$msg = 'Question not found.';
			return Redirect::to(route('config.supplier'))->with('STATUS_FAIL', $msg);
		}
	}





	// Buyer
	public function GET_buyer()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.buyer');

		$buyers = Buyer::orderBy('name', 'asc')->get();

		$update = new Buyer;
		$params = array('buyers' => $buyers, 'update' => $update, 'id' => '');
		return $theme->scope('config.buyer', $params)->render();
	}

	public function POST_buyer()
	{
		if (Input::has('name') && Input::has('email')) {
			$chk = Buyer::orWhere('id', Input::get('id'))
						->orWhere('email', Input::get('email'))->count();
			if($chk == 0) {
				$buyer = new Buyer;
				$buyer->id = Input::get('id');
				$buyer->name = Input::get('name');
				$buyer->email = Input::get('email');
				$buyer->status = Input::get('status'); //-- 1=active, 0-inactive
				$buyer->save();

				$msg = 'New buyer successfully added.';
				return Redirect::back()->with('STATUS_OK', $msg);
			} else {
				$msg = 'Buyer with ID or Email provided already exists.';
				return Redirect::back()->with('STATUS_FAIL', $msg);
			}
		} else {
			$msg = 'Field Name &amp; Email cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function GET_buyerUpdate($id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->setMenu('config.buyer');

		$buyers = Buyer::orderBy('name', 'asc')->get();
		$update = Buyer::find($id);
		$params = array('buyers' => $buyers, 'update' => $update, 'id' => $id);
		return $theme->scope('config.buyer_edit', $params)->render();
	}

	public function PUT_buyer($id)
	{
		if (Input::has('name') && Input::has('email') && $id) {
			$buyer = Buyer::find($id);
			// $buyer->id = Input::get('id');
			$buyer->name = Input::get('name');
			$buyer->email = Input::get('email');
			$buyer->status = Input::get('status'); //-- 1=active, 0-inactive
			$buyer->save();

			$msg = 'Buyer details successfully updated.';
			return Redirect::to(route('config.buyer'))->with('STATUS_OK', $msg);
		} else {
			$msg = 'Field Name &amp; Email cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function DELETE_buyer($id)
	{
		if ($id) {
			$buyer = Buyer::find($id);
			$buyer->delete();
			$msg = 'Selected buyer successfully deleted.';
			return Redirect::to(route('config.buyer'))->with('STATUS_OK', $msg);
		}else {
			$msg = 'Buyer not found.';
			return Redirect::to(route('config.buyer'))->with('STATUS_FAIL', $msg);
		}
	}



	// Vendor
	public function GET_vendor()
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('config.vendor');

		$theme->asset()->container('post-styles')->usePath()->add('dataTables.bootstrap', 'js/datatables/datatables.css');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->asset()->container('post-scripts')->usePath()->add('jquery_dataTables', 'js/datatables/jquery.dataTables.min.js?'.time());
		$theme->asset()->container('post-scripts')->usePath()->add('dataTables_bootstrap', 'js/datatables/dataTables.bootstrap.js?'.time());
		$theme->asset()->container('post-scripts')->usePath()->add('dataTables_custom', 'js/datatables/custom.js?'.time());

		$vendors = Vendor::orderBy('name', 'asc')->get();

		$update = new Vendor;
		$params = array('vendors' => $vendors, 'update' => $update, 'id' => '');
		return $theme->scope('config.vendor', $params)->render();
	}

	public function POST_vendor()
	{
		if (Input::has('name')) {
			$chk = Vendor::orWhere('id', Input::get('id'))->count();
			if($chk == 0) {
				$vendor = new Vendor;
				$vendor->id = Input::get('id');
				$vendor->name = Input::get('name');
				$vendor->contact = Input::get('contact');
				$vendor->status = Input::get('status'); //-- 1=active, 0-inactive
				$vendor->save();

				$msg = 'New vendor successfully added.';
				return Redirect::back()->with('STATUS_OK', $msg);
			} else {
				$msg = 'Vendor with ID provided already exists.';
				return Redirect::back()->with('STATUS_FAIL', $msg);
			}
		} else {
			$msg = 'Field Name cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function GET_vendorUpdate($id)
	{
		$theme = Theme::uses('notebook')->layout('main');
		$theme->setMenu('config.vendor');

		$theme->asset()->container('post-styles')->usePath()->add('dataTables.bootstrap', 'js/datatables/datatables.css');
		$theme->asset()->container('post-scripts')->usePath()->add('laravel', 'js/laravel.js');
		$theme->asset()->container('post-scripts')->usePath()->add('jquery_dataTables', 'js/datatables/jquery.dataTables.min.js?'.time());
		$theme->asset()->container('post-scripts')->usePath()->add('dataTables_bootstrap', 'js/datatables/dataTables.bootstrap.js?'.time());
		$theme->asset()->container('post-scripts')->usePath()->add('dataTables_custom', 'js/datatables/custom.js?'.time());

		$vendors = Vendor::orderBy('name', 'asc')->get();
		$update = Vendor::find($id);
		$params = array('vendors' => $vendors, 'update' => $update, 'id' => $id);
		return $theme->scope('config.vendor_edit', $params)->render();
	}

	public function PUT_vendor($id)
	{
		if (Input::has('name') && $id) {
			$vendor = Vendor::find($id);
			// $vendor->id = Input::get('id');
			$vendor->name = Input::get('name');
			$vendor->contact = Input::get('contact');
			$vendor->status = Input::get('status'); //-- 1=active, 0-inactive
			$vendor->save();

			$msg = 'Vendor details successfully updated.';
			return Redirect::to(route('config.vendor'))->with('STATUS_OK', $msg);
		} else {
			$msg = 'Field Name cannot be empty.';
			return Redirect::back()->with('STATUS_FAIL', $msg);
		}
	}

	public function DELETE_vendor($id)
	{
		if ($id) {
			$vendor = Vendor::find($id);
			$vendor->delete();
			$msg = 'Selected vendor successfully deleted.';
			return Redirect::to(route('config.vendor'))->with('STATUS_OK', $msg);
		}else {
			$msg = 'Vendor not found.';
			return Redirect::to(route('config.vendor'))->with('STATUS_FAIL', $msg);
		}
	}

}
