<?php

class Timelines extends Projects {
	var $module;
	
	function __construct($name) {
		$this->module = $name;
		$this->form_url = "apps/projects/modules/$name/";
		$this->model = new TimelinesModel();
		$this->binDisplay = false;
	}
	
	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$timelines = $arr["timelines"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getDetails($id,$pid) {
		global $date,$lang;
		switch($id) {
			case "1":
				$data["what"] = $id;
				$project = $this->model->getBarchartDetails($pid);
				include('view/barchart.php');
			break;
			case "2":
				$data["what"] = $id;
				$project = $this->model->getDetails($pid);
				include('view/schedule.php');
			break;
			case "3":
				$data["what"] = $id;
				$project = $this->model->getDetails($pid);
				include('view/psp.php');
			break;
		}
	}


	function printDetails($id,$pid,$t) {
		global $lang;
		$title = "";
		$html = "";
		if($project = $this->model->getDetails($pid)) {
			ob_start();
				include 'view/print_schedule.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $project["title"] . " - " . TIMELINE_DATES_LIST;
		}
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}


	function getSend($id,$pid) {
		global $projectsmodel, $lang;
		
		$form_url = "apps/projects/modules/timelines/";
		$request = "sendDetails";
		$to = "";
		$cc = "";
		$subject = $projectsmodel->getProjectTitle($pid) . " - " . TIMELINE_DATES_LIST;
		$variable = $pid;
		include CO_INC .'/view/dialog_send.php';
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $projectsmodel,$session,$users, $lang;
		$title = "";
		$html = "";
		if($project = $this->model->getDetails($variable)) {
			ob_start();
				include 'view/print_schedule.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $project["title"] . " - " . TIMELINE_DATES_LIST;
		}
		$attachment = CO_PATH_PDF . "/" . $title . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
}

$timelines = new Timelines("timelines");
?>