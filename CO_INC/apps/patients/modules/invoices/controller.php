<?php

class PatientsInvoices extends Patients {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/patients/modules/$name/";
			$this->model = new PatientsInvoicesModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$invoices = $arr["invoices"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PATIENT_INVOICE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$invoice = $arr["invoice"];
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

	function getPrintOptions() {
		global $lang;
			ob_start();
				include 'view/print_options.php';
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	function getSendToOptions() {
		global $lang;
			ob_start();
				include 'view/sendto_options.php';
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}
	
	
	function printDetails($id,$t,$option) {
		global $session, $lang;
		$title = "";
		$html = "";
		switch($option) {
			case 'invoice':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid)) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_invoice.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $lang["PATIENT_INVOICE_TITLE"] . ' ' . $invoice->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				switch($t) {
					case "html":
						$this->printHTML($title,$html,1,'logo_print_patient.png');
					break;
					default:
						$this->printPDF($title,$html,1,'logo_print_patient.png');
				}
			break;
			case 'reminder':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid)) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_reminder.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $lang["PATIENT_INVOICE_PAYMENT_REMINDER"] . ' ' . $invoice->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				switch($t) {
					case "html":
						$this->printHTML($title,$html,1,'logo_print_patient.png');
					break;
					default:
						$this->printPDF($title,$html,1,'logo_print_patient.png');
				}
			break;
			case 'stationary':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid)) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_stationary.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = 'Kuvert ' . $invoice->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				switch($t) {
					case "html":
						$this->printHTML($title,$html,1,'logo_print_patient.png');
					break;
					default:
						$this->printPDF($title,$html,1,'logo_print_patient.png');
				}
			break;
		}
	}

	
	function getSend($id,$option) {
		global $lang;
		if($arr = $this->model->getDetails($id,'prepareSendTo')) {
			$invoice = $arr["invoice"];
			$pid = $invoice->pid;
			if($arr = $this->model->getPatientDetails($pid)) {
				$patient = $arr["patient"];
			}
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $invoice->title;
			$variable = $option;
			
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
		switch($variable) {
			case 'invoice':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid)) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_invoice.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $invoice->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment,1,'logo_print_patient.png');
			break;
			case 'reminder':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid)) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_reminder.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $invoice->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment,1,'logo_print_patient.png');
			break;
			case 'stationary':
				if($arr = $this->model->getDetails($id)) {
					$invoice = $arr["invoice"];
					$pid = $invoice->pid;
					if($arr = $this->model->getPatientDetails($pid)) {
						$patient = $arr["patient"];
					}
					ob_start();
						include 'view/print_stationary.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $invoice->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_INVOICE"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment,1,'logo_print_patient.png');
			break;
		}
		
		
		
		// write sento log
		$this->writeSendtoLog("patients_invoices",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	

	function setDetails($pid,$id,$invoice_date,$invoice_date_sent,$invoice_number,$payment_reminder,$protocol_payment_reminder,$protocol,$documents) {
		if($retval = $this->model->setDetails($pid,$id,$invoice_date,$invoice_date_sent,$invoice_number,$payment_reminder,$protocol_payment_reminder,$protocol,$documents)){
			return '{ "id": "' . $id . '"}';
		} else{
			return "error";
		}
	}
	
	function updateStatus($id,$date,$status) {
		$arr = $this->model->updateStatus($id,$date,$status);
		return '{"id": "' . $arr["id"] . '", "status": "' . $status . '"}';
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

	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_INVOICE_HELP"];
		$data["app"] = "patients";
		$data["module"] = "/modules/invoices";
		$this->openHelpPDF($data);
	}


	function updateQuestion($id,$field,$val){
		$this->model->updateQuestion($id,$field,$val);
		return true;
   }

}

$patientsInvoices = new PatientsInvoices("invoices");
?>