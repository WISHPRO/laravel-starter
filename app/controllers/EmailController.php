<?php

class EmailController extends BaseController
{

	private $today;

	public function __construct()
	{
		$this->today = new DateTime('today');
	}
	
	public function GET_survey()
	{
		// Mail::pretend();

		$emails = array();
		$names = array();
		$totals = array();
		$projects = Project::where('actual_date', '<=', $this->today)
							->orderBy('actual_date', 'asc')->get();
						// where(function($query){
						// 	$query->orWhere(function($query1){
						// 			$query1->where('delay', 0)
						// 				   ->where('actual_date', '<=', $this->today);
						// 		  })
						// 		  ->orWhere(function($query2){
						// 		  	$query2->where('delay', 1)
						// 		  		   ->where('delay_date', '<=', $this->today);
						// 		  });
						// })
		foreach ($projects as $project) {
			foreach ($project->survey as $survey) {
				if($survey->status == 0) {
					if(!isset($totals[$survey->assessor->id])) $totals[$survey->assessor->id] = 1;
					else $totals[$survey->assessor->id] += 1;
					if(!in_array($survey->assessor->email, $emails)) {
						$emails[$survey->assessor->id] = $survey->assessor->email;
						$names[$survey->assessor->id] = $survey->assessor->first_name;
					}
				}
			}
		}

		// Testing Only
		// $email = 'khairulnizam.dahari@prasarana.com.my';
		// $name = 'khairulnizam';
		// $total = 15;
		foreach ($emails as $key => $email) {
			$name = $names[$key];
			$total = $totals[$key];

			$params = array(
				'logoPath' => public_path() . '/themes/notebook/assets/img/prasarana_logo.png',
				'email' => $email,
				'total' => $total
				);

			Mail::send('emails.survey', $params, function($message) use($email, $name) {
				$message->to($email, $name)
						->subject('VPA: Vendor Performance Appraisal System');
			});
		}

		return 'DONE';
	}


	public function GET_welcome()
	{
		$params = array(
			'logoPath' => public_path() . '/themes/notebook/assets/img/prasarana_logo.png'
			);

		Mail::send('emails.survey', $params, function($message) {
		  $message->to('khairulnizam.dahari@prasarana.com.my', 'khairulnizam')
		          ->subject('VPA: Vendor Performance Appraisal System');
		});
	}

}