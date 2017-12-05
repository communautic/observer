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
			$task_bar = $arr["task_bar"];
			$bar_compare_array = $arr["bar_compare_array"];
			//$diagnose = $arr["diagnose"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			$data["invoice_no"] = $treatment->invoice_no;
			//$data["canvases"] = $diagnose;
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
			case 'plan':
				if($arr = $this->model->getDetails($id)) {
					$treatment = $arr["treatment"];
					$task = $arr["task"];
			$task_bar = $arr["task_bar"];
			$bar_compare_array = $arr["bar_compare_array"];
					$sendto = $arr["sendto"];
					$printcanvas = 0;
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
			break;
			case 'docu':
				if($arr = $this->model->getDetails($id)) {
					$treatment = $arr["treatment"];
					$task = $arr["task"];
					//$diagnose = $arr["diagnose"];
					$sendto = $arr["sendto"];
					$printcanvas = 0;
					ob_start();
						include 'view/print_docu.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $treatment->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_TREATMENT_DOCU"];
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printPDF($title,$html);
				}
			break;
			case 'list':
				if($arr = $this->model->getDetails($id)) {
					$treatment = $arr["treatment"];
					$task = $arr["task"];
					//$diagnose = $arr["diagnose"];
					$sendto = $arr["sendto"];
					$printcanvas = 0;
					$terminliste_text = CO_PATH_DATA . '/templates/terminliste_text.php';
					if(file_exists($terminliste_text)) {
						ob_start();
							include $terminliste_text;
							$html .= ob_get_contents();
						ob_end_clean();
					}
					ob_start();
						include 'view/print_list.php';
						$html .= ob_get_contents();
					ob_end_clean();
					$title = $treatment->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_TREATMENT_LIST"];
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printPDF($title,$html);
				}
			break;
		}
	}
	
	function getSend($id,$option) {
		global $lang;
		if($arr = $this->model->getDetails($id,'prepareSendTo')) {
			$treatment = $arr["treatment"];
			$task = $arr["task"];
			//$diagnose = $arr["diagnose"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $treatment->title;
			$variable = $option;
			
			$data["error"] = 0;
			$data["error_message"] = "";
			/*if($treatment->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $treatment->sendtoTeamNoEmail;
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
		switch($variable) {
			case 'plan':
				if($arr = $this->model->getDetails($id)) {
					$treatment = $arr["treatment"];
					$task = $arr["task"];
					//$diagnose = $arr["diagnose"];
					$sendto = $arr["sendto"];
					$printcanvas = 0;
					ob_start();
						include 'view/print.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $treatment->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_TREATMENT"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment);
			break;
			case 'docu':
				if($arr = $this->model->getDetails($id)) {
					$treatment = $arr["treatment"];
					$task = $arr["task"];
					//$diagnose = $arr["diagnose"];
					$sendto = $arr["sendto"];
					$printcanvas = 0;
					ob_start();
						include 'view/print_docu.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $treatment->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_TREATMENT_DOCU"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment);
			break;
			case 'list':
				if($arr = $this->model->getDetails($id)) {
					$treatment = $arr["treatment"];
					$task = $arr["task"];
					//$diagnose = $arr["diagnose"];
					$sendto = $arr["sendto"];
					$printcanvas = 0;
					ob_start();
						include 'view/print_list.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $treatment->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_TREATMENT_LIST"];
				$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
				$pdf = $this->savePDF($title,$html,$attachment);
			break;
		}
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
	

	function setDetails($pid,$id,$title,$treatmentdate,$protocol,$method,$protocol2,$protocol3,$discount,$vat,$doctor,$doctor_ct,$task_id,$task_date,$task_text,$task,$task_treatmenttype,$canvasList_id,$canvasList_text,$treatment_access,$treatment_access_orig,$documents) {
		if($arr = $this->model->setDetails($pid,$id,$title,$treatmentdate,$protocol,$method,$protocol2,$protocol3,$discount,$vat,$doctor,$doctor_ct,$task_id,$task_date,$task_text,$task,$task_treatmenttype,$canvasList_id,$canvasList_text,$treatment_access,$treatment_access_orig,$documents)){
			 return '{ "id": "' . $arr["id"] . '", "access": "' . $treatment_access . '", "changeTreatmentStatus": "' . $arr["changeTreatmentStatus"] . '", "updatestatus": "' . $arr["updatestatus"]->sessionvalstext . '"}';
		  } else{
			 return "error";
		  }
	}


	function updateStatus($id,$date,$status) {
		$changePatientStatus = 0;
		$retval = $this->model->updateStatus($id,$date,$status);
		if($status == 1) {
			$checkPatient = $this->model->updateStatusPatient($id);
			if($checkPatient){
				$changePatientStatus = 1;
			}
		}
		if($status == 2) {
			
			$checkPatient = $this->model->checkPatientFinished($id);
			if($checkPatient){
				$changePatientStatus = 2;
			}
		}
		if($status == 3) {
				$changePatientStatus = 2;
		}
		if($retval){
			return '{ "id": "' . $id . '", "status": "' . $status . '", "changePatientStatus": "' . $changePatientStatus . '"}';
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


	function addTask($pid,$mid,$num,$sort) {
		global $lang;
		$task = $this->model->addTask($pid,$mid,$num,$sort);
		$treatment->canedit = 1;
		$i = $sort+1;
		foreach($task as $value) {
			$checked = '';
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
	

	function restoreTreatmentDiagnose($id) {
		$retval = $this->model->restoreTreatmentDiagnose($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteTreatmentDiagnose($id) {
		$retval = $this->model->deleteTreatmentDiagnose($id);
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
	
	function getTreatmentsTypeDialog($field,$append) {
		global $lang;
		$treatments = $this->model->getLast10Treatments();
		/*if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }*/
		  include_once dirname(__FILE__).'/view/dialog_treatments.php';
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
	//diagnose
	function updatePosition($id,$x,$y){
		$this->model->updatePosition($id,$x,$y);
		return true;
   }
   
   function addDiagnose($mid,$num) {
		if($retval = $this->model->addDiagnose($mid,$num)){
			return $retval;
		} else{
			return "error";
		}
	}
	
 function binDiagnose($id) {
		$this->model->binDiagnose($id);
		return true;
	}
	
	function saveDrawing($id,$img){
		$this->model->saveDrawing($id,$img);
		return true;
   }
   
   function getTreatmentTypeMin($id) {
		if($retval = $this->model->getTreatmentTypeMin($id)){
			return $retval;
		} else{
			return "error";
		}
	}
	
	function getTreatmentsSearch($term) {
		$search = $this->model->getTreatmentsSearch($term);
		return $search;
	}
	
	function getTaskContext($id,$field) {
		global $lang;
		//if($arr = $this->model->getTaskContext($id,$field)) {
			//$treatment = $arr["treatment"];
			include 'view/context.php';
		//}
	}
	
	function saveLastUsedTreatments($id) {
		$retval = $this->model->saveLastUsedTreatments($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}
	function getTreatmentsMethodDialog($field) {
		$retval = $this->model->getTreatmentsMethodDialog($field);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getTreatmentInfoForCalendar($id) {
		global $lang;
		if($arr = $this->model->getTreatmentInfoForCalendar($id)) {
			$treatment = $arr["treatment"];
			return json_encode($treatment);
		}
	}
	
	function getMethodContext($id,$field,$edit) {
		global $lang;
		$context = $this->model->getMethodContext($id,$field);
		include 'view/method_context.php';
	}
	
	function getCoPopup($id) {
		global $system, $lang;
		if($arr = $this->model->getBarTreatmentTasks($id)) {
			$tasks = $arr['tasks'];
			//print_r($tasks);
			//$tasks = $arr["tasks"];
			//echo $tasks;
			//ob_start();
				include 'view/copopup.php';
				//$html = ob_get_contents();
			//ob_end_clean();
			//return $html;
		}
	}
	
	function generateInvoice($id) {
		global $lang;
		if($arr = $this->model->generateInvoice($id)) {
			return json_encode($arr);
		}
	}
	
	function generateBarzahlung($tid,$tasks) {
		global $lang;
		if( $bar = $this->model->generateBarzahlung($tid,$tasks)) {
			if($arr = $this->model->getDetails($tid)) {
				$treatment = $arr["treatment"];
				$task = $arr["task"];
				$task_bar = $arr["task_bar"];
				$bar_compare_array = $arr["bar_compare_array"];
				$html = '';
				
					
					foreach($task_bar as $value) { 
               include("view/tasks_bar.php");
							 ob_start();
					//include 'view/edit.php';
					$html .= ob_get_contents();
					ob_end_clean();
						}
					
				
				//$data["canvases"] = $diagnose;
				return $html;
			} else {
				return 'error';
			}
			return true;
		}
	}
	
	function deleteBarBeleg($id) {
		global $lang;
		if( $bar = $this->model->deleteBarBeleg($id)) {
			return json_encode($bar);
		}
	}
	
	
	
}

$patientsTreatments = new PatientsTreatments("treatments");
?>