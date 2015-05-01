<?php
class TrainingsControlling extends Trainings {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/trainings/modules/$name/";
			$this->model = new TrainingsControllingModel();
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
		$data["title"] = "";
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
		global $session, $trainingsmodel,$lang;
		$title = "";
		$html = "";
		$tit = $trainingsmodel->getTrainingTitle($pid);
		if($cont = $this->model->getDetails($pid)) {
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title =  $tit . " - " . $lang["TRAINING_CONTROLLING_STATUS"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["TRAINING_PRINT_CONTROLLING"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}


	function getSend($id,$pid) {
		global $trainingsmodel,$lang;
		$form_url = "apps/trainings/modules/controlling/";
		$request = "sendDetails";
		$to = "";
		$cc = "";
		$subject = $trainingsmodel->getTrainingTitle($pid) . " - " . $lang["TRAINING_CONTROLLING_STATUS"];
		$variable = $pid;
		include CO_INC .'/view/dialog_send.php';
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $trainingsmodel,$session,$users, $lang;
		$title = "";
		$html = "";
		$tit = $trainingsmodel->getTrainingTitle($variable);
		if($cont = $this->model->getDetails($variable)) {
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title =  $tit . " - " . $lang["TRAINING_CONTROLLING_STATUS"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["TRAINING_PRINT_CONTROLLING"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("trainings_controlling",$id,$to);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function getDailyStatistic() {
		echo $this->model->getDailyStatistic();
	}


	function getChart($id,$what,$value,$print=0,$type=0) {
		global $lang;
		if($chart = $this->model->getChart($id,$what,$value)) {
			if($type == 1) {
				if($print == 1) {
					include 'view/chart_status_print.php';
				} else {
					include 'view/chart_status.php';
				}
			} else {
				if($print == 1) {
					include CO_INC .'/apps/trainings/view/chart_print.php';
				} else {
					include CO_INC .'/apps/trainings/view/chart.php';
				}
			}
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function getHelp() {
		global $lang;
		$data["file"] = $lang["TRAINING_CONTROLLING_HELP"];
		$data["app"] = "trainings";
		$data["module"] = "/modules/controlling";
		$this->openHelpPDF($data);
	}

	
}

$trainingsControlling = new TrainingsControlling("controlling");
?>