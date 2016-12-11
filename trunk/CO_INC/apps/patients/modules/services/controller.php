<?php

class PatientsServices extends Patients {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/patients/modules/$name/";
			$this->model = new PatientsServicesModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$services = $arr["services"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PATIENT_SERVICE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$service = $arr["service"];
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
			$service = $arr["service"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $service->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_SERVICE"];
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
			$service = $arr["service"];
			$task = $arr["task"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = '';
			$cc = "";
			$subject = $service->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			/*if($service->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $service->sendtoTeamNoEmail;
			}*/
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
			$service = $arr["service"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $service->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_SERVICE"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("patients_services",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinService($id) {
		if($id != "undefined") {
			return $this->model->checkinService($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$discount,$vat,$task_id,$task_title,$task_text2,$task_text3,$task,$task_sort,$documents,$service_access,$service_access_orig) {
		if($arr = $this->model->setDetails($pid,$id,$title,$discount,$vat,$task_id,$task_title,$task_text2,$task_text3,$task,$task_sort,$documents,$service_access,$service_access_orig)){
			return '{ "id": "' . $id . '", "access": "' . $service_access . '", "totalcosts": "' . $arr['totalcosts'] . '", "changeServiceStatus": "' . $arr["changeServiceStatus"] . '"}';
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
			 return '{ "what": "service" , "action": "new", "id": "' . $retval . '" }';
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


	function binService($id) {
		$retval = $this->model->binService($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreService($id) {
		$retval = $this->model->restoreService($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteService($id) {
		$retval = $this->model->deleteService($id);
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
		$task = $this->model->addTask($mid,$num,$sort);
		$service->canedit = 1;
		foreach($task as $value) {
			$checked = '';
			if($value->status == 1) {
				$checked = ' checked="checked"';
			}
			include 'view/task.php';
		}
	}


	function sortItems($task) {
		$retval = $this->model->sortItems($task);
			if($retval){
			 return 'true';
		  } else{
			 return "error";
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
	
	function restoreServiceTask($id) {
		$retval = $this->model->restoreServiceTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteServiceTask($id) {
		$retval = $this->model->deleteServiceTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getServiceStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_SERVICE_HELP"];
		$data["app"] = "patients";
		$data["module"] = "/modules/services";
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


	function getPatientsDialog() {
		global $system, $lang;
		$patients = $this->model->getLast10Patients();
		include('view/dialog_copy.php');
	}
	
	
	function copyService($pid,$phid) {
		global $lang;
		$patient = $this->model->copyService($pid,$phid);
		return json_encode($patient);
	}
	
}

$patientsServices = new PatientsServices("services");
?>