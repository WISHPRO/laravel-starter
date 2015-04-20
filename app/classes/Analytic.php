<?php

class Analytic {

	public function __construct()
	{

	}

	public static function grade($score)
	{
		if ($score >= 19 && $score <= 27) {
			$grade = 'Good';
		} else if ($score >= 10 && $score <= 18) {
			$grade = 'Average';
		} else if ($score < 10) {
			$grade = 'Poor';
		}
		return $grade;
	}

	public static function totalProject($vendor_id)
	{
		$project_count = Project::where('vendor_id', $vendor_id)->count();
		return $project_count;
	}

	public static function assessedProject($vendor_id)
	{
		$projects = Project::select('id')->where('vendor_id', $vendor_id)->get();
		$project_count = 0;
		foreach ($projects as $project) {
			if (self::assessedSurveyByProject($project->id)) {
				$project_count++;
			}
		}
		return $project_count;
	}

	public static function completedProjects()
	{
		$projects = Project::all();
		$project_list = [];
		foreach ($projects as $project) {
			if (self::assessedSurveyByProject($project->id)) {
				$project_list[] = $project->id;
			}
		}
		return $project_list;
	}

	// public static function assessedSurveyByVendor($vendor_id)
	// {
	// 	$projects = Project::select('id')->where('vendor_id', $vendor_id)->get();
	// 	$unanswered = array();
	// 	$i = 0;
	// 	foreach ($projects as $project) {
	// 		$unanswered_surveys = Survey::where('project_id', $project->id)->where('status', 0)->count();
	// 		if ($unanswered_surveys > 0) {
	// 			$unanswered[] = $project->id;
	// 		}
	// 		$i++;
	// 	}
	// 	$incomplete = count($unanswered);
	// 	$complete = $i - $incomplete;
	// 	return array('complete' => $complete, 'incomplete' => $incomplete);
	// }

	public static function assessedSurveyByProject($project_id)
	{
		$incomplete = Survey::where('project_id', $project_id)->where('status', 0)->count();
		if ($incomplete > 0) {
			return false; // Incomplete
		} else {
			return true;  // Completed
		}
	}

	public static function projectScore($project_id)
	{
		$mark = 0;
		$i = 0;
		$percentage = 0;
		$surveys = Survey::where('project_id', $project_id)->get();
		if($surveys && self::assessedSurveyByProject($project_id)) {
			foreach ($surveys as $key => $survey) {
				foreach ($survey->answers as $answer) {
					$mark += $answer->mark;
					$i++;
				}
			}
		}
		$result = array('count' => $i, 'mark' => $mark, 'grade' => self::grade($mark));
		return $result;
	}

	public static function totalScore($vendor_id)
	{
		$mark = 0;
		$i = 0;
		$percentage = 0;
		$projects = Project::where('vendor_id', $vendor_id)->get();
		if($projects) {
			foreach ($projects as $project) {
				if(self::assessedSurveyByProject($project->id)) {
					$projectScore = Analytic::projectScore($project->id);
					$mark += $projectScore['mark'];
					$i++;
				}
			}
			// if($i > 0) $percentage = sprintf("%0.0f", $mark / ($i * 3) * 100);
			// else $percentage = 0;
			if($i > 0) {
				$average = ceil($mark / $i);
				$grade = self::grade($average);
			} else {
				$average = 0;
				$grade = '--';
			}
		}
		$result = array('count' => $i, 'mark' => $average, 'grade' => $grade);
		return $result;
	}

	public static function rankings($vendor_type=0)
	{
		$i = 0;
		$ratings = array();
		$projects = Project::select('vendor_id')->groupBy('vendor_id')->get();

		foreach ($projects as $project) {
			$result = Analytic::totalScore($project->vendor_id);
			$ratings['vendor'][$i] = $project->vendor_id;
			$ratings['rate'][$i] = $result['rate'];
			$ratings['mark'][$i] = $result['mark'];
			$i++;
		}
		array_multisort($ratings['rate'], SORT_NUMERIC, SORT_DESC,
						$ratings['mark'], SORT_NUMERIC, SORT_DESC,
						$ratings['vendor'], SORT_NUMERIC, SORT_ASC);
		return $ratings;
	}

	public static function vendorRanking($vendor_id, $vendor_type=0)
	{
		$totalScore = Analytic::totalScore($vendor_id);
		if($totalScore['mark'] > 0) {
			$ratings = Analytic::rankings($vendor_type);
			$total = count($ratings['vendor']);
			$number = $total;
			foreach ($ratings['vendor'] as $key => $vendor) {
				if($vendor == $vendor_id) {
					$number = $key + 1;
					continue;
				}
			}
			return ordinal($number) . ' /' . $total;
		} else {
			return '--';
		}
	}


}