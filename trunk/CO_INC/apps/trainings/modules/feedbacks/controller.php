<?php

class TrainingsFeedbacks extends Trainings {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/trainings/modules/$name/";
			$this->model = new TrainingsFeedbacksModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$feedbacks = $arr["feedbacks"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["TRAINING_FEEDBACK_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$feedback = $arr["feedback"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return json_encode($data);
		} else {
			ob_start();
				include CO_INC .'/view/default.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function printDetails($id,$t) {
		global $session, $lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getDetails($id)) {
			$feedback = $arr["feedback"];
			$pid = $feedback->pid;
			if($arr = $this->model->getTrainingDetails($pid)) {
				$training = $arr["training"];
			}
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $feedback->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["TRAINING_PRINT_FEEDBACK"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html,1,'logo_print_training.png');
			break;
			default:
				$this->printPDF($title,$html,1,'logo_print_training.png');
		}
	}

	
	function getSend($id) {
		global $lang;
		if($arr = $this->model->getDetails($id,'prepareSendTo')) {
			$feedback = $arr["feedback"];
			$pid = $feedback->pid;
			if($arr = $this->model->getTrainingDetails($pid)) {
				$training = $arr["training"];
			}
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $feedback->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session, $users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$feedback = $arr["feedback"];
			$pid = $feedback->pid;
			if($arr = $this->model->getTrainingDetails($pid)) {
				$training = $arr["training"];
			}
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $feedback->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["TRAINING_PRINT_FEEDBACK"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment,1,'logo_print_training.png');
		
		// write sento log
		$this->writeSendtoLog("trainings_feedbacks",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	

	function setDetails($pid,$id,$protocol) {
		if($retval = $this->model->setDetails($pid,$id,$protocol)){
			return '{ "id": "' . $id . '"}';
		} else{
			return "error";
		}
	}

	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["TRAINING_FEEDBACK_HELP"];
		$data["app"] = "trainings";
		$data["module"] = "/modules/feedbacks";
		$this->openHelpPDF($data);
	}


	function updateQuestion($id,$field,$val){
		$this->model->updateQuestion($id,$field,$val);
		return true;
   }

}

$trainingsFeedbacks = new TrainingsFeedbacks("feedbacks");
?>