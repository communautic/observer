<?php

class PatientsTreatments extends Patients {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/patients/modules/$name/";
			$this->model = new PatientsTreatmentsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$treatments = $arr["treatments"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PATIENT_TREATMENT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$treatment = $arr["treatment"];
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
			$treatment = $arr["treatment"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $treatment->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_TREATMENT"];
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
			$treatment = $arr["treatment"];
			$task = $arr["task"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $treatment->sendtoTeam;
			$cc = "";
			$subject = $treatment->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			if($treatment->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $treatment->sendtoTeamNoEmail;
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
			$treatment = $arr["treatment"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $treatment->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_TREATMENT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("patients_treatments",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinTreatment($id) {
		if($id != "undefined") {
			return $this->model->checkinTreatment($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$treatmentdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct, $tab1q1_text,$tab1q2_text,$tab1q3_text,$tab1q4_text,$tab1q5_text,$tab2q1_text,$tab2q2_text,$tab2q3_text,$tab2q4_text,$tab2q5_text,$tab2q6_text,$tab2q7_text,$tab2q8_text,$tab2q9_text,$tab2q10_text,$task_id,$task_title,$task_text,$task,$treatment_access,$treatment_access_orig) {
		if($retval = $this->model->setDetails($pid,$id,$title,$treatmentdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$tab1q1_text,$tab1q2_text,$tab1q3_text,$tab1q4_text,$tab1q5_text,$tab2q1_text,$tab2q2_text,$tab2q3_text,$tab2q4_text,$tab2q5_text,$tab2q6_text,$tab2q7_text,$tab2q8_text,$tab2q9_text,$tab2q10_text,$task_id,$task_title,$task_text,$task,$treatment_access,$treatment_access_orig)){
			return '{ "id": "' . $id . '", "access": "' . $treatment_access . '"}';
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
			 return '{ "what": "treatment" , "action": "new", "id": "' . $retval . '" }';
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


	function binTreatment($id) {
		$retval = $this->model->binTreatment($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreTreatment($id) {
		$retval = $this->model->restoreTreatment($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteTreatment($id) {
		$retval = $this->model->deleteTreatment($id);
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
		$treatment->canedit = 1;
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
	
	function restoreTreatmentTask($id) {
		$retval = $this->model->restoreTreatmentTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteTreatmentTask($id) {
		$retval = $this->model->deleteTreatmentTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getTreatmentStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_TREATMENT_HELP"];
		$data["app"] = "patients";
		$data["module"] = "/modules/treatments";
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

$patientsTreatments = new PatientsTreatments("treatments");
?>