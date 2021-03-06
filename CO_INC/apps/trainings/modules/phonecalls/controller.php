<?php

class TrainingsPhonecalls extends Trainings {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/trainings/modules/$name/";
			$this->model = new TrainingsPhonecallsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$phonecalls = $arr["phonecalls"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["TRAINING_PHONECALL_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$phonecall = $arr["phonecall"];
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
			$phonecall = $arr["phonecall"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $phonecall->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["TRAINING_PRINT_PHONECALL"];
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
			$phonecall = $arr["phonecall"];			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $phonecall->sendtoTeam;
			$cc = "";
			$subject = $phonecall->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			if($phonecall->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $phonecall->sendtoTeamNoEmail;
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
			$phonecall = $arr["phonecall"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $phonecall->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["TRAINING_PRINT_PHONECALL"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("trainings_phonecalls",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function checkinPhonecall($id) {
		if($id != "undefined") {
			return $this->model->checkinPhonecall($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$phonecalldate,$start,$end,$protocol,$management,$management_ct,$documents,$phonecall_access,$phonecall_access_orig,$phonecall_status,$phonecall_status_date) {
		if($arr = $this->model->setDetails($pid,$id,$title,$phonecalldate,$start,$end,$protocol,$management,$management_ct,$documents,$phonecall_access,$phonecall_access_orig,$phonecall_status,$phonecall_status_date)){
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $phonecall_access . '", "status": "' . $phonecall_status . '"}';
		} else{
			return "error";
		}
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "phonecall" , "action": "new", "id": "' . $retval . '" }';
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


	function binPhonecall($id) {
		$retval = $this->model->binPhonecall($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restorePhonecall($id) {
		$retval = $this->model->restorePhonecall($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deletePhonecall($id) {
		$retval = $this->model->deletePhonecall($id);
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

	
	function getPhonecallStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}


	function getHelp() {
		global $lang;
		$data["file"] =  $lang["TRAINING_PHONECALL_HELP"];
		$data["app"] = "trainings";
		$data["module"] = "/modules/phonecalls";
		$this->openHelpPDF($data);
	}
	
}

$trainingsPhonecalls = new TrainingsPhonecalls("phonecalls");
?>