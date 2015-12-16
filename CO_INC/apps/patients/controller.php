<?php

//include_once("lang/" . $session->userlang . ".php");

class Patients extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new PatientsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			$this->archiveDisplay = false;
			$this->contactsDisplay = true; // list access status on contact page
			
			if (!$session->isSysadmin()) {
				$this->canView = $this->model->getViewPerms($session->uid);
				$this->canEdit = $this->model->getEditPerms($session->uid);
				$this->canAccess = array_merge($this->canView,$this->canEdit);
			}
	}


	function getFolderList($sort) {
		global $system, $lang;
		$arr = $this->model->getFolderList($sort);
		$folders = $arr["folders"];
		ob_start();
			include('view/folders_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["access"] = $arr["access"];
		$data["title"] = $lang["PATIENT_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			ob_start();
			include 'view/folder_edit.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}
	
	
	function getFolderDetailsList($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			ob_start();
			include 'view/folder_edit_list.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}
	
	
	function getFolderDetailsInvoices($id,$view) {
		global $date, $lang, $system;
		if($arr = $this->model->getFolderDetailsInvoices($id,$view)) {
		$invoices = $arr["invoices"];
		ob_start();
			include('view/folder_edit_invoices.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["access"] = $arr["access"];
		return $system->json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}
	
	function getFolderDetailsRevenue($id) {
		global $date, $lang, $system;
		$start = new DateTime("first day of last month");
		$end = new DateTime("last day of last month");
		$start_date = $start->format('d.m.Y');
		$end_date = $end->format('d.m.Y');
		ob_start();
			include('view/folder_edit_revenue.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		return json_encode($data);
	}
	
	function getFolderDetailsRevenueResults($id,$who,$start,$end) {
		global $date, $lang, $system;
		$arr = $this->model->getFolderDetailsRevenueResults($id,$who,$start,$end);
		$calctotal = $arr["calctotal"];
		$invoices = $arr["invoices"];
		ob_start();
			include('view/folder_edit_revenue_results.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["access"] = $arr["access"];
		return json_encode($data);
	}
	
	function getFolderDetailsBelege($id) {
		global $date, $lang, $system;
		$start = new DateTime("first day of last month");
		$end = new DateTime("last day of last month");
		$start_date = $start->format('d.m.Y');
		$end_date = $end->format('d.m.Y');
		ob_start();
			include('view/folder_edit_belege.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		return json_encode($data);
	}
	
	function getFolderDetailsBelegeResults($id,$who,$start,$end) {
		global $date, $lang, $system;
		$arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end);
		$calctotal = $arr["calctotal"];
		$zahlungen = $arr["zahlungen"];
		$storno = $arr["storno"];
		$invoices = $arr["invoices"];
		ob_start();
			include('view/folder_edit_belege_results.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["access"] = $arr["access"];
		return json_encode($data);
	}


	function printFolderDetailsList($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	
	function printFolderDetailsInvoices($id,$view) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		if($arr = $this->model->getFolderDetailsInvoices($id,$view)) {
			  $invoices = $arr["invoices"];
				ob_start();
					include('view/folder_print_invoices.php');
					$html = ob_get_contents();
				ob_end_clean();		
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_RECHNUNGEN"];
		$this->printPDF($title,$html);
	}


	function printFolderDetailsRevenue($id,$who,$start,$end) {
		global $date,$session,$lang;
		$title = $lang["PATIENT_FOLDER_TAB_REVENUE"];
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			//$title = $lang["PATIENT_FOLDER_TAB_REVENUE"];
		}
		if($arr = $this->model->getFolderDetailsRevenueResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$calctotalmin = $arr["calctotalmin"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			ob_start();
				include('view/folder_print_revenue.php');
				$html = ob_get_contents();
			ob_end_clean();	
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_UMSATZ"];
		$this->printPDF($title,$html);
	}
	
	function printFolderDetailsBelege($id,$who,$start,$end) {
		global $date,$session,$lang;
		$title = 'Belegarchiv';
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			//$title = $lang["PATIENT_FOLDER_TAB_REVENUE"];
		}
		if($arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$zahlungen = $arr["zahlungen"];
			$storno = $arr["storno"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			ob_start();
				include('view/folder_print_belege.php');
				$html = ob_get_contents();
			ob_end_clean();	
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_BELEGE"];
		$this->printPDF($title,$html);
	}


	function getFolderSend($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];	
			$form_url = $this->form_url;
			$request = "sendFolderDetails";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}

	function sendFolderDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$patients = $arr["patients"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("patients",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	
	function getFolderSendInvoices($id,$view) {
		global $lang;
		if($arr = $this->model->getFolderDetailsInvoices($id,$view)) {
			$invoices = $arr["invoices"];
			if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
		}
			$form_url = $this->form_url;
			$request = "sendFolderDetailsInvoices";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = $view;
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}

	function sendFolderDetailsInvoices($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		if($arr = $this->model->getFolderDetailsInvoices($id,$variable)) {
			$invoices = $arr["invoices"];
			ob_start();
				include 'view/folder_print_invoices.php';
				$html = ob_get_contents();
			ob_end_clean();
			//$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function getFolderSendRevenue($id,$who,$start,$end) {
		global $lang;
		if($arr = $this->model->getFolderDetailsRevenueResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
		}
			$form_url = $this->form_url;
			$request = "sendFolderDetailsRevenue";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = $who.'-'.$start.'-'.$end;
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function getFolderSendBelege($id,$who,$start,$end) {
		global $lang;
		if($arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
		}
			$form_url = $this->form_url;
			$request = "sendFolderDetailsBelege";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = $who.'-'.$start.'-'.$end;
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}

	function sendFolderDetailsRevenue($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		$var = explode("-", $variable);
		$who = $var[0];
		$start = $var[1];
		$end = $var[2];
		if($arr = $this->model->getFolderDetailsRevenueResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			ob_start();
				include 'view/folder_print_revenue.php';
				$html = ob_get_contents();
			ob_end_clean();
			//$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function sendFolderDetailsBelege($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$title = $folder->title;
		}
		$var = explode("-", $variable);
		$who = $var[0];
		$start = $var[1];
		$end = $var[2];
		if($arr = $this->model->getFolderDetailsBelegeResults($id,$who,$start,$end)) {
			$calctotal = $arr["calctotal"];
			$invoices = $arr["invoices"];
			$manager = $arr["manager"];
			ob_start();
				include 'view/folder_print_revenue.php';
				$html = ob_get_contents();
			ob_end_clean();
			//$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"patients","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$patientstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$patientstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $patientstatus . '", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function binFolder($id) {
		$retval = $this->model->binFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreFolder($id) {
		$retval = $this->model->restoreFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function deleteFolder($id) {
		$retval = $this->model->deleteFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function getPatientList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getPatientList($id,$sort);
		$patients = $arr["patients"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["PATIENT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getPatientDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getPatientDetails($id)) {
			$patient = $arr["patient"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		}
		else {
			ob_start();
				include CO_INC .'/view/default.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}


	function printPatientDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getPatientDetails($id)) {
			$patient = $arr["patient"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $patient->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printPatientHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getPatientDetails($id,'nocheckout')) {
			$patient = $arr["patient"];
			//$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/handbook_cover.php';
				$html .= ob_get_contents();
			ob_end_clean();
			ob_start();
				include 'view/print.php';
				$html .= ob_get_contents();
			ob_end_clean();
			// treatments
			$patientsTreatments = new PatientsTreatments("treatments");
			if($arrts = $patientsTreatments->model->getList($id,"0")) {
				$ts = $arrts["treatments"];
				foreach ($ts as $t) {
					if($arr = $patientsTreatments->model->getDetails($t->id)) {
						$treatment = $arr["treatment"];
						$t = $arr["t"];
						$task = $arr["task"];
						$diagnose = $arr["diagnose"];
						$sendto = $arr["sendto"];
						$printcanvas = 0;
						ob_start();
							include 'modules/treatments/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
				//$html .= '<div style="page-break-after:always;">&nbsp;</div>';
			}
			
			
			// visualisierungen
			$patientsSketches = new PatientsSketches("sketches");
			if($arrrs = $patientsSketches->model->getList($id,"0")) {
				$rs = $arrrs["sketches"];
				foreach ($rs as $r) {
					if($arr = $patientsSketches->model->getDetails($r->id)) {
						$sketch = $arr["sketch"];
						$diagnose = $arr["diagnose"];
						$r = $arr["r"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/sketches/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
				//$html .= '<div style="page-break-after:always;">&nbsp;</div>';
			}
			
			// reports
			$patientsReports = new PatientsReports("reports");
			if($arrrs = $patientsReports->model->getList($id,"0")) {
				$rs = $arrrs["reports"];
				foreach ($rs as $r) {
					if($arr = $patientsReports->model->getDetails($r->id)) {
						$report = $arr["report"];
						$r = $arr["r"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/reports/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
				//$html .= '<div style="page-break-after:always;">&nbsp;</div>';
			}

			$title = $patient->title . " - " . $lang["PATIENT_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinPatient($id) {
		if($id != "undefined") {
			return $this->model->checkinPatient($id);
		} else {
			return true;
		}
	}

	function getPatientSend($id) {
		global $lang;
		if($arr = $this->model->getPatientDetails($id, 'prepareSendTo')) {
			$patient = $arr["patient"];
			$form_url = $this->form_url;
			$request = "sendPatientDetails";
			$to = "";
			$cc = "";
			$subject = $patient->title;
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


	function sendPatientDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getPatientDetails($id)) {
			$patient = $arr["patient"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $patient->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PATIENT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("patients",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newPatient($id,$cid) {
		$retval = $this->model->newPatient($id,$cid);
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
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


	function setPatientDetails($id,$folder,$management,$management_ct,$insurer,$insurer_ct,$protocol,$number,$number_insurer,$insurance,$insuranceadd,$code,$dob,$familystatus,$coo,$documents) {
		$retval = $this->model->setPatientDetails($id,$folder,$management,$management_ct,$insurer,$insurer_ct,$protocol,$number,$number_insurer,$insurance,$insuranceadd,$code,$dob,$familystatus,$coo,$documents);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '"}';
		  } else{
			 return "error";
		  }
	}
	
	
	function updateStatus($id,$date,$status) {
		$retval = $this->model->updateStatus($id,$date,$status);
		if($retval){
			 return '{ "id": "' . $id . '", "status": "' . $status . '"}';
		 }
	}


	function binPatient($id) {
		$retval = $this->model->binPatient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restorePatient($id) {
		$retval = $this->model->restorePatient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deletePatient($id) {
		$retval = $this->model->deletePatient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function movePatient($id,$startdate,$movedays) {
		$retval = $this->model->movePatient($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getPatientFolderDialog($field,$title) {
		$retval = $this->model->getPatientFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getPatientFolderDialogCalendar($field,$title) {
		$retval = $this->model->getPatientFolderDialogCalendar($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getPatientStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getPatientDialog($field,$sql) {
		$retval = $this->model->getPatientDialog($field,$sql);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getPatientDialogInsuranceAdd($field) {
		global $lang;
		include_once dirname(__FILE__).'/view/dialog_insurance.php';
	}
	

	function getPatientMoreDialog($field,$title) {
		$retval = $this->model->getPatientMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	function getPatientCatDialog($field,$title) {
		$retval = $this->model->getPatientCatDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getPatientCatMoreDialog($field,$title) {
		$retval = $this->model->getPatientCatMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getCalendarContactsDialog($field,$append) {
		global $lang;
		$contactsmmodel = new ContactsModel();
		$contacts = $contactsmmodel->getLast10Contacts();
		include_once dirname(__FILE__).'/view/dialog_calendar_contacts.php';
	}
	function getCalendarContactsSearch($term) {
		$search = $this->model->getCalendarContactsSearch($term);
		return $search;
	}
	
	function getCalendarPatientsDialog($field,$append) {
		global $lang;
		$patients = $this->model->getLast10Patients();
		include_once dirname(__FILE__).'/view/dialog_calendar_patients.php';
	}
	function getCalendarPatientsSearch($term) {
		$search = $this->model->getCalendarPatientsSearch($term);
		return $search;
	}
	
	function getCalendarFoldersDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}
	
	function getTreatmentsContactsDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}
	
	/*function getTreatmentsPatientsDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}*/
	
	function getTreatmentsDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10CalTreatments();
		include_once dirname(__FILE__).'/view/dialog_treatments.php';
	}
	
	function getCalendarTreatmentsSearch($term) {
		$search = $this->model->getCalendarTreatmentsSearch($term);
		return $search;
	}
	

	function getAccessDialog() {
		global $lang;
		include 'view/dialog_access.php';
	}


	// STATISTICS
	function getChartFolder($id,$what,$print=0,$type=0) {
		global $lang;
		if($chart = $this->model->getChartFolder($id,$what)) {
				if($type == 1) {
					if($print == 1) {
						include 'view/chart_status_print.php';
					} else {
						include 'view/chart_status.php';
					}
				} else {
					if($print == 1) {
						include 'view/chart_print.php';
					} else {
						include 'view/chart.php';
					}
				}
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function getChartPerformance($id,$what,$print=0,$type=0) {
		global $lang;
		if($chart = $this->model->getChartPerformance($id,$what)) {
			if($print == 1) {
				include 'view/chart_print.php';
			} else {
				include 'view/chart.php';
			}
		} else {
			include CO_INC .'/view/default.php';
		}
	}

	
	
	function getPatientsHelp() {
		global $lang;
		$data["file"] = $lang["PATIENT_HELP"];
		$data["app"] = "patients";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getPatientsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_FOLDER_HELP"];
		$data["app"] = "patients";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $patients;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $patients;
		if($arr = $this->model->emptyBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	// User Access
	function isAdmin(){
	  global $session;
	  /*if($this->model->isPatientOwner($session->uid)) {
	  	return true;
	  }*/
	  $canEdit = $this->model->getEditPerms($session->uid);
	  return !empty($canEdit);
   }
   
   function isGuest(){
	  global $session;
	  $canView = $this->model->getViewPerms($session->uid);
	  return !empty($canView);
   }

	function getNavModulesNumItems($id) {
		$arr = $this->model->getNavModulesNumItems($id);
		return json_encode($arr);
	}
	
	/*function getPatientTitle($id){
		$title = $this->model->getPatientTitle($id);
		return $title;
   }*/
   
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
   
   function getCheckpointDetails($app,$module,$id) {
	   global $projects;
	   $retval = $this->model->getCheckpointDetails($app,$module,$id);
	   if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
   }   

	function updateCheckpointText($id,$text){
		$this->model->updateCheckpointText($id,$text);
		return true;
   }


	function getPatientsSearch($term,$exclude) {
		$search = $this->model->getPatientsSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedPatients($id) {
		$retval = $this->model->saveLastUsedPatients($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}


	function getGlobalSearch($term) {
		$search = $this->model->getGlobalSearch($term);
		return $search;
	}
	
	function getInlineSearch($term) {
		$search = $this->model->getInlineSearch($term);
		return $search;
	}
	
	function getInsuranceContext($id,$field,$edit) {
		global $lang;
		$context = $this->model->getInsuranceContext($id,$field);
		include 'view/insurance_context.php';
	}
	
	function getWidgetAlerts() {
		global $lang, $system;
		if($arr = $this->model->getWidgetAlerts()) {
			$alerts = $arr["alerts"];
			$reminders = $arr["reminders"];
			$waitinglist = $arr["waitinglist"];
			ob_start();
			include 'view/widget.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["widgetaction"] = $arr["widgetaction"];
			return json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}
	
	function getPatientInfoForCalendar($id) {
		$arr = $this->model->getPatientInfoForCalendar($id);
		return json_encode($arr);
	}
   
}

$patients = new Patients("patients");
?>