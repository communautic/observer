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

function getSendTotals($id) {
		global $lang;
		if($arr = $this->model->getDetailsTotals($id,'prepareSendTo')) {
			$feedback = $arr["feedback"];
			if($arr = $this->model->getTrainingDetails($id)) {
				$training = $arr["training"];
			}
			
			$form_url = $this->form_url;
			$request = "sendDetailsTotals";
			$to = "";
			$cc = "";
			$subject = $training->title;
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
		//$this->writeSendtoLog("trainings_feedbacks",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	
	function checkinFeedback($id) {
		if($id != "undefined") {
			return $this->model->checkinFeedback($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$protocol) {
		if($retval = $this->model->setDetails($pid,$id,$protocol)){
			return '{ "id": "' . $id . '"}';
		} else{
			return "error";
		}
	}


	function updateStatus($id,$date,$status) {
		$arr = $this->model->updateStatus($id,$date,$status);
		if($arr["what"] == "edit") {
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "status": "' . $status . '"}';
		} else {
			return '{ "action": "reload" , "id": "' . $arr["id"] . '"}';
		}
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "feedback" , "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}


	function createDuplicate($id) {
		$retval = $this->model->createDuplicate($id);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function binFeedback($id) {
		$retval = $this->model->binFeedback($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreFeedback($id) {
		$retval = $this->model->restoreFeedback($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteFeedback($id) {
		$retval = $this->model->deleteFeedback($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function toggleIntern($id,$status) {
		$retval = $this->model->toggleIntern($id,$status);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function addTask($mid,$num,$sort) {
		global $lang;
		$task = $this->model->addTask($mid,$num,$sort);
		$feedback->canedit = 1;
		foreach($task as $value) {
			$checked = '';
			$donedate_field = 'display: none';
			$donedate = $value->today;
			if($value->status == 1) {
				$checked = ' checked="checked"';
			}
			include 'view/task.php';
		}
	}


	function deleteTask($id) {
		$retval = $this->model->deleteTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function restoreFeedbackTask($id) {
		$retval = $this->model->restoreFeedbackTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteFeedbackTask($id) {
		$retval = $this->model->deleteFeedbackTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getFeedbackStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	
	function getFeedbackCatDialog($field) {
		$retval = $this->model->getFeedbackCatDialog($field);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function changeCat($id,$cat) {
		global $lang;
		$retval = $this->model->changeCat($id,$cat);
		if($retval){
			$data['q1'] = $lang["TRAINING_FEEDBACK_TAB2_CAT" . $cat . "_QUESTION_1"];
			$data['q2'] = $lang["TRAINING_FEEDBACK_TAB2_CAT" . $cat . "_QUESTION_2"];
			$data['q3'] = $lang["TRAINING_FEEDBACK_TAB2_CAT" . $cat . "_QUESTION_3"];
			$data['q4'] = $lang["TRAINING_FEEDBACK_TAB2_CAT" . $cat . "_QUESTION_4"];
			$data['q5'] = $lang["TRAINING_FEEDBACK_TAB2_CAT" . $cat . "_QUESTION_5"];
			 return json_encode($data);
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

 	function newCheckpoint($id,$date){
		$this->model->newCheckpoint($id,$date);
		return true;
   }

 	function updateCheckpoint($id,$date){
		$this->model->updateCheckpoint($id,$date);
		return true;
   }

 	function deleteCheckpoint($id){
		$this->model->deleteCheckpoint($id);
		return true;
   }
   
	function updateCheckpointText($id,$text){
		$this->model->updateCheckpointText($id,$text);
		return true;
   }
   
	function updateQuestion($id,$field,$val){
		$this->model->updateQuestion($id,$field,$val);
		return true;
   }
   function updateTaskQuestion($id,$val){
		$this->model->updateTaskQuestion($id,$val);
		return true;
   }

}

$trainingsFeedbacks = new TrainingsFeedbacks("feedbacks");
?>