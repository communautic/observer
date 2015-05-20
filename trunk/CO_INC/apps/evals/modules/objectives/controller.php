<?php

class EvalsObjectives extends Evals {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/evals/modules/$name/";
			$this->model = new EvalsObjectivesModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$objectives = $arr["objectives"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["EVAL_OBJECTIVE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$objective = $arr["objective"];
			$task = $arr["task"];
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
			$objective = $arr["objective"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $objective->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["EVAL_PRINT_OBJECTIVE"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	function getSend($id) {
		global $lang;
		if($arr = $this->model->getDetails($id,'prepareSendTo')) {
			$objective = $arr["objective"];
			$task = $arr["task"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $objective->sendtoTeam;
			$cc = "";
			$subject = $objective->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			if($objective->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $objective->sendtoTeamNoEmail;
			}
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
			$objective = $arr["objective"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $objective->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["EVAL_PRINT_OBJECTIVE"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("evals_objectives",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinObjective($id) {
		if($id != "undefined") {
			return $this->model->checkinObjective($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$objectivedate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$protocol,$protocol2, $tab1q1_text,$tab1q2_text,$tab1q3_text,$tab1q4_text,$tab1q5_text,$tab1q6_text,$tab1q7_text,$tab1q8_text,$tab1q9_text,$tab1q10_text,$tab1q11_text,$tab1q12_text,$tab1q13_text,$tab1q14_text,$tab1q15_text,$tab1q16_text,$tab1q17_text,$tab2q1_text,$tab2q2_text,$tab2q3_text,$tab2q4_text,$tab2q5_text,$tab2q6_text,$tab2q7_text,$tab2q8_text,$tab2q9_text,$tab2q10_text,$tab2q11_text,$tab2q12_text,$tab2q13_text,$tab2q14_text,$tab2q15_text,$tab2q16_text,$tab2q17_text,$tab3q1_text,$tab3q2_text,$tab3q3_text,$tab3q4_text,$tab3q5_text,$tab3q6_text,$tab3q7_text,$tab3q8_text,$tab3q9_text,$tab3q10_text,$tab3q11_text,$tab3q12_text,$tab3q13_text,$tab3q14_text,$tab3q15_text,$tab3q16_text,$tab3q17_text,$task_id,$task_title,$task_text,$task,$objective_access,$objective_access_orig) {
		if($retval = $this->model->setDetails($pid,$id,$title,$objectivedate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$protocol,$protocol2,$tab1q1_text,$tab1q2_text,$tab1q3_text,$tab1q4_text,$tab1q5_text,$tab1q6_text,$tab1q7_text,$tab1q8_text,$tab1q9_text,$tab1q10_text,$tab1q11_text,$tab1q12_text,$tab1q13_text,$tab1q14_text,$tab1q15_text,$tab1q16_text,$tab1q17_text,$tab2q1_text,$tab2q2_text,$tab2q3_text,$tab2q4_text,$tab2q5_text,$tab2q6_text,$tab2q7_text,$tab2q8_text,$tab2q9_text,$tab2q10_text,$tab2q11_text,$tab2q12_text,$tab2q13_text,$tab2q14_text,$tab2q15_text,$tab2q16_text,$tab2q17_text,$tab3q1_text,$tab3q2_text,$tab3q3_text,$tab3q4_text,$tab3q5_text,$tab3q6_text,$tab3q7_text,$tab3q8_text,$tab3q9_text,$tab3q10_text,$tab3q11_text,$tab3q12_text,$tab3q13_text,$tab3q14_text,$tab3q15_text,$tab3q16_text,$tab3q17_text,$task_id,$task_title,$task_text,$task,$objective_access,$objective_access_orig)){
			return '{ "id": "' . $id . '", "access": "' . $objective_access . '"}';
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
			 return '{ "what": "objective" , "action": "new", "id": "' . $retval . '" }';
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


	function binObjective($id) {
		$retval = $this->model->binObjective($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreObjective($id) {
		$retval = $this->model->restoreObjective($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteObjective($id) {
		$retval = $this->model->deleteObjective($id);
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
		$objective->canedit = 1;
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
	
	function restoreObjectiveTask($id) {
		$retval = $this->model->restoreObjectiveTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteObjectiveTask($id) {
		$retval = $this->model->deleteObjectiveTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getObjectiveStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	
	function getObjectiveCatDialog($field) {
		$retval = $this->model->getObjectiveCatDialog($field);
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
			$data['q1'] = $lang["EVAL_OBJECTIVE_TAB2_CAT" . $cat . "_QUESTION_1"];
			$data['q2'] = $lang["EVAL_OBJECTIVE_TAB2_CAT" . $cat . "_QUESTION_2"];
			$data['q3'] = $lang["EVAL_OBJECTIVE_TAB2_CAT" . $cat . "_QUESTION_3"];
			$data['q4'] = $lang["EVAL_OBJECTIVE_TAB2_CAT" . $cat . "_QUESTION_4"];
			$data['q5'] = $lang["EVAL_OBJECTIVE_TAB2_CAT" . $cat . "_QUESTION_5"];
			 return json_encode($data);
		  } else{
			 return "error";
		  }
	}
	
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["EVAL_OBJECTIVE_HELP"];
		$data["app"] = "evals";
		$data["module"] = "/modules/objectives";
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

$evalsObjectives = new EvalsObjectives("objectives");
?>