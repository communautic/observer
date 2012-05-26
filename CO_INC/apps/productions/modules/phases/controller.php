<?php

class ProductionsPhases extends Productions {
	var $module;


	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/productions/modules/$name/";
			$this->model = new ProductionsPhasesModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$phases = $arr["phases"];
		$num = $arr["num"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PRODUCTION_PHASE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id,$num) {
		global $lang, $system;
		if($arr = $this->model->getDetails($id,$num)) {
			$phase = $arr["phase"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			//include('view/edit.php');
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


	function printDetails($id,$num,$t) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id,$num)) {
			$phase = $arr["phase"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $phase->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRODUCTION_PRINT_PHASE"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	function getSend($id,$num) {
		global $lang;
		if($arr = $this->model->getDetails($id,$num)) {
			$phase = $arr["phase"];
			$task = $arr["task"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $phase->team;
			$cc = "";
			$subject = $phase->title;
			$variable = $num;
			
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id,$variable)) {
			$phase = $arr["phase"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $phase->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRODUCTION_PRINT_PHASE"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("productions_phases",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinPhase($id) {
		if($id != "undefined") {
			return $this->model->checkinPhase($id);
		} else {
			return true;
		}
	}


	function setDetails($id,$title,$team,$team_ct,$protocol,$documents,$phase_access,$phase_access_orig,$phase_status,$phase_status_date,$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task_protocol,$task,$task_cat,$task_dependent,$task_team,$task_team_ct) {
		if($arr = $this->model->setDetails($id,$title,$team,$team_ct,$protocol,$documents,$phase_access,$phase_access_orig,$phase_status,$phase_status_date,$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task_protocol,$task,$task_cat,$task_dependent,$task_team,$task_team_ct)){
			 return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $phase_access . '", "status": "' . $phase_status . '", "startdate": "' . $arr["startdate"] . '", "enddate": "' . $arr["enddate"] . '"}';
		  } else{
			 return "error";
		  }
	}


	function createNew($id,$num) {
		$retval = $this->model->createNew($id,$num);
		if($retval){
			 return '{ "what": "phase" , "action": "new", "id": "' . $retval . '" }';
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


	function binPhase($id) {
		$retval = $this->model->binPhase($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restorePhase($id) {
		$retval = $this->model->restorePhase($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function deletePhase($id) {
		$retval = $this->model->deletePhase($id);
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


	function getPhaseTaskDialog() {
		global $lang;
		include 'view/dialog_task.php';
	}


	function getTasksDialog($id,$field) {
		$retval = $this->model->getTasksDialog($id,$field);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	
	function getTaskContext($id,$field) {
		global $lang;
		$context = $this->model->getTaskContext($id,$field);
		include 'view/context.php';
	}
	

	function getTaskDependencyExists($id) {
		$retval = $this->model->getTaskDependencyExists($id);
		//return $retval;
		if($retval){
			 return "true";
		  } else{
			 return "false";
		  }
	}
	
	function moveDependendTasks($id,$days) {
		$retval = $this->model->moveDependendTasks($id,$days);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}

	function addTask($pid,$phid,$date,$cat) {
		global $lang;
		$task = $this->model->addTask($pid,$phid,$date,$cat);
		$phase->canedit = 1;
		foreach($task as $value) {
			$checked = '';
			$donedate_field = 'display: none';
			$donedate = $value->today;
			if($value->status == 1) {
				$checked = ' checked="checked"';
			}
			if($value->cat == 0) {
				include 'view/task.php';
			} else {
				include 'view/milestone.php';
			}
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


	function deletePhaseTask($id) {
		$retval = $this->model->deletePhaseTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function restorePhaseTask($id) {
		$retval = $this->model->restorePhaseTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function getPhaseStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}

	function getPhasesBin($id) {
		$arr = $this->model->getPhasesBin($id);
		return $arr;
		/*if($retval){
			return "true";
		} else{
			return "error";
		}*/
		//return $this->model->getBin($id);
	}
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PRODUCTION_PHASE_HELP"];
		$data["app"] = "productions";
		$data["module"] = "/modules/phases";
		$this->openHelpPDF($data);
	}

}

$productionsPhases = new ProductionsPhases("phases");
?>