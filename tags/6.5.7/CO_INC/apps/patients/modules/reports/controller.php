<?php

class PatientsReports extends Patients {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/patients/modules/$name/";
			$this->model = new PatientsReportsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$reports = $arr["reports"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PATIENT_REPORT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$report = $arr["report"];
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
			$report = $arr["report"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $report->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_REPORT"];
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
			$report = $arr["report"];			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $report->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			/*if($report->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $report->sendtoTeamNoEmail;
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
			$report = $arr["report"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $report->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_REPORT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("patients_reports",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function checkinReport($id) {
		if($id != "undefined") {
			return $this->model->checkinReport($id);
		} else {
			return true;
		}
	}

	function setDetailsTitle($pid,$id,$title,$reportdate) {
		if($arr = $this->model->setDetailsTitle($pid,$id,$title,$reportdate)){
			return '{ "action": "editTitle" , "id": "' . $arr["id"] . '"}';
		} else{
			return "error";
		}
	}

	function setDetails($pid,$id,$title,$reportdate,$protocol,$protocol2,$feedback,$documents,$report_access,$report_access_orig) {
		if($arr = $this->model->setDetails($pid,$id,$title,$reportdate,$protocol,$protocol2,$feedback,$documents,$report_access,$report_access_orig)){
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $report_access . '"}';
		} else{
			return "error";
		}
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "report" , "action": "new", "id": "' . $retval . '" }';
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


	function binReport($id) {
		$retval = $this->model->binReport($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreReport($id) {
		$retval = $this->model->restoreReport($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteReport($id) {
		$retval = $this->model->deleteReport($id);
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

	
	function getReportStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}


	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_REPORT_HELP"];
		$data["app"] = "patients";
		$data["module"] = "/modules/reports";
		$this->openHelpPDF($data);
	}
	
	
	function getReportsTreatmentsDialog($field,$sql) {
		$retval = $this->model->getReportsTreatmentsDialog($field,$sql);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function setTreatmentID($pid,$tid) {
		$retval = $this->model->setTreatmentID($pid,$tid);
		if($retval){
			 return true;
		  } else{
			 return "error";
		  }
	}
	
}

$patientsReports = new PatientsReports("reports");
?>