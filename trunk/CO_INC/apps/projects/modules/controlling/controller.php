<?php
class Controlling extends Projects {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new ControllingModel();
			$this->binDisplay = false;
	}


	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$controlling = $arr["controlling"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}


	function getDetails($id,$pid) {
		global $lang;
		if($controlling = $this->model->getDetails($pid)) {
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}


	function printDetails($id,$pid,$t) {
		global $projectsmodel,$lang;
		$title = "";
		$html = "";
		$tit = $projectsmodel->getProjectTitle($pid);
		if($controlling = $this->model->getDetails($pid)) {
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title =  $tit . " - " . $lang["CONTROLLING_STATUS"];
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
		global $projectsmodel,$lang;
		$form_url = "apps/projects/modules/controlling/";
		$request = "sendDetails";
		$to = "";
		$cc = "";
		$subject = $projectsmodel->getProjectTitle($pid) . " - " . $lang["CONTROLLING_STATUS"];
		$variable = $pid;
		include CO_INC .'/view/dialog_send.php';
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $projectsmodel,$session,$users, $lang;
		$title = "";
		$html = "";
		$tit = $projectsmodel->getProjectTitle($variable);
		if($controlling = $this->model->getDetails($variable)) {
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title =  $tit . " - " . $lang["CONTROLLING_STATUS"];
		}
		$attachment = CO_PATH_PDF . "/" . $title . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function getDailyStatistic() {
		echo $this->model->getDailyStatistic();
	}


	function getChart($id,$what, $print=0) {
		if($chart = $this->model->getChart($id,$what)) {
				if($print == 1) {
					include CO_INC .'/apps/projects/view/chart_print.php';
				} else {
					include CO_INC .'/apps/projects/view/chart.php';
				}
				
		} else {
			include CO_INC .'/view/default.php';
		}
	}

	
}

$controlling = new Controlling("controlling");
?>