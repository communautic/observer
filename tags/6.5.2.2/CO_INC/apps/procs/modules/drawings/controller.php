<?php

class ProcsDrawings extends Procs {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/procs/modules/$name/";
			$this->model = new ProcsDrawingsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$drawings = $arr["drawings"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PROC_DRAWING_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$drawing = $arr["drawing"];
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


	function printDetails($id,$t) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$drawing = $arr["drawing"];
			$task = $arr["task"];
			$diagnose = $arr["diagnose"];
			$sendto = $arr["sendto"];
			$printcanvas = 1;
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $drawing->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROC_PRINT_DRAWING"];
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
			$drawing = $arr["drawing"];
			$task = $arr["task"];
			$diagnose = $arr["diagnose"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $drawing->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			/*if($drawing->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $drawing->sendtoTeamNoEmail;
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
			$drawing = $arr["drawing"];
			$task = $arr["task"];
			$diagnose = $arr["diagnose"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $drawing->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROC_PRINT_DRAWING"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("procs_drawings",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinDrawing($id) {
		if($id != "undefined") {
			return $this->model->checkinDrawing($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title) {
		if($retval = $this->model->setDetails($pid,$id,$title)){
			return '{ "id": "' . $id . '"}';
		} else{
			return "error";
		}
	}


	function updateStatus($id,$date,$status) {
		$arr = $this->model->updateStatus($id,$date,$status);
		//if($arr["what"] == "edit") {
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "status": "' . $status . '"}';
		/*} else {
			return '{ "action": "reload" , "id": "' . $arr["id"] . '"}';
		}*/
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "drawing" , "action": "new", "id": "' . $retval . '" }';
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


	function binDrawing($id) {
		$retval = $this->model->binDrawing($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreDrawing($id) {
		$retval = $this->model->restoreDrawing($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteDrawing($id) {
		$retval = $this->model->deleteDrawing($id);
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
		$drawing->canedit = 1;
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
	
	function restoreDrawingTask($id) {
		$retval = $this->model->restoreDrawingTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteDrawingTask($id) {
		$retval = $this->model->deleteDrawingTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	

	function restoreDrawingDiagnose($id) {
		$retval = $this->model->restoreDrawingDiagnose($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteDrawingDiagnose($id) {
		$retval = $this->model->deleteDrawingDiagnose($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getDrawingStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getDrawingsTypeDialog($field) {
		$retval = $this->model->getDrawingsTypeDialog($field);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PROC_DRAWING_HELP"];
		$data["app"] = "procs";
		$data["module"] = "/modules/drawings";
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
   
   function getDrawingTypeMin($id) {
		if($retval = $this->model->getDrawingTypeMin($id)){
			return $retval;
		} else{
			return "error";
		}
	}

}

$procsDrawings = new ProcsDrawings("drawings");
?>