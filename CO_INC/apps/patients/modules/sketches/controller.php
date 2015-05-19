<?php

class PatientsSketches extends Patients {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/patients/modules/$name/";
			$this->model = new PatientsSketchesModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$sketches = $arr["sketches"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PATIENT_SKETCH_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$sketch = $arr["sketch"];
			//$task = $arr["task"];
			$diagnose = $arr["diagnose"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			$data["canvases"] = $diagnose;
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
					$sketch = $arr["sketch"];
					//$task = $arr["task"];
					$diagnose = $arr["diagnose"];
					$sendto = $arr["sendto"];
					$printcanvas = 1;
					ob_start();
						include 'view/print.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $sketch->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_SKETCH"];
				switch($t) {
					case "html":
						$this->printHTML($title,$html);
					break;
					default:
						$this->printSketch($title,$html);
				}
			break;
			case 'list':
				if($arr = $this->model->getDetails($id)) {
					$sketch = $arr["sketch"];
					//$task = $arr["task"];
					$diagnose = $arr["diagnose"];
					$sendto = $arr["sendto"];
					$printcanvas = 1;
					ob_start();
						include 'view/print_list.php';
						$html = ob_get_contents();
					ob_end_clean();
					$title = $sketch->title;
				}
				$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_SKETCH"];
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
	
	function getSend($id) {
		global $lang;
		if($arr = $this->model->getDetails($id,'prepareSendTo')) {
			$sketch = $arr["sketch"];
			//$task = $arr["task"];
			$diagnose = $arr["diagnose"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $sketch->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			/*if($sketch->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $sketch->sendtoTeamNoEmail;
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
			$sketch = $arr["sketch"];
			//$task = $arr["task"];
			$diagnose = $arr["diagnose"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $sketch->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PATIENT_PRINT_SKETCH"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("patients_sketches",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinSketch($id) {
		if($id != "undefined") {
			return $this->model->checkinSketch($id);
		} else {
			return true;
		}
	}

	function setDetails($pid,$id,$title,$canvasList_id,$canvasList_text,$sketch_access,$sketch_access_orig) {
		if($arr = $this->model->setDetails($pid,$id,$title,$canvasList_id,$canvasList_text,$sketch_access,$sketch_access_orig)){
			 return '{ "id": "' . $arr["id"] . '", "access": "' . $sketch_access . '"}';
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

	function getNewOptions() {
		global $lang;
			ob_start();
				include 'view/new_options.php';
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}

	function createNew($id,$type,$image) {
		$retval = $this->model->createNew($id,$type,$image);
		if($retval){
			 return '{ "what": "sketch" , "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function createNewImage($id) {
		global $lang;
			ob_start();
				include 'view/new.php';
				$html = ob_get_contents();
			ob_end_clean();
			return $html;
	}


	function createDuplicate($id) {
		$retval = $this->model->createDuplicate($id);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function binSketch($id) {
		$retval = $this->model->binSketch($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreSketch($id) {
		$retval = $this->model->restoreSketch($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteSketch($id) {
		$retval = $this->model->deleteSketch($id);
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
		$sketch->canedit = 1;
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
	
	function restoreSketchTask($id) {
		$retval = $this->model->restoreSketchTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteSketchTask($id) {
		$retval = $this->model->deleteSketchTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	

	function restoreSketchDiagnose($id) {
		$retval = $this->model->restoreSketchDiagnose($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteSketchDiagnose($id) {
		$retval = $this->model->deleteSketchDiagnose($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getSketchStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getSketchesTypeDialog($field,$append) {
		global $lang;
		$sketches = $this->model->getLast10Sketches();
		/*if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }*/
		  include_once dirname(__FILE__).'/view/dialog_sketches.php';
	}
	
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PATIENT_SKETCH_HELP"];
		$data["app"] = "patients";
		$data["module"] = "/modules/sketches";
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
		if($arr = $this->model->addDiagnose($mid,$num)){
			//return $retval;
			return json_encode($arr);
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
   
   function getSketchTypeMin($id) {
		if($retval = $this->model->getSketchTypeMin($id)){
			return $retval;
		} else{
			return "error";
		}
	}
	
	function getSketchesSearch($term) {
		$search = $this->model->getSketchesSearch($term);
		return $search;
	}
	
	function getTaskContext($id,$field) {
		global $lang;
		//if($arr = $this->model->getTaskContext($id,$field)) {
			//$sketch = $arr["sketch"];
			include 'view/context.php';
		//}
	}
	
	function saveLastUsedSketches($id) {
		$retval = $this->model->saveLastUsedSketches($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}
}

$patientsSketches = new PatientsSketches("sketches");
?>