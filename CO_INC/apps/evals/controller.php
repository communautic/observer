<?php

//include_once("lang/" . $session->userlang . ".php");

class Evals extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new EvalsModel();
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
		$data["title"] = $lang["EVAL_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$evals = $arr["evals"];
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


	function printFolderDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$evals = $arr["evals"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EVAL_FOLDER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function getFolderSend($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$evals = $arr["evals"];	
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
			$evals = $arr["evals"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EVAL_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("evals",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"evals","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$evalstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$evalstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $evalstatus . '", "id": "' . $id . '" }';
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


	function getEvalList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getEvalList($id,$sort);
		$evals = $arr["evals"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["EVAL_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getEvalDetails($id,$applications) {
		global $lang, $system;
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEvalTrainingsDetails($id);
			}
		}
		if($arr = $this->model->getEvalDetails($id)) {
			$eval = $arr["eval"];
			$leistungen = $arr["leistungen"];
			$trainings = $trainings;
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


	function printEvalDetails($id, $t,$applications) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEvalTrainingsDetails($id);
			}
		}
		if($arr = $this->model->getEvalDetails($id)) {
			$eval = $arr["eval"];
			$leistungen = $arr["leistungen"];
			$trainings = $trainings;
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $eval->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EVAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printEvalHandbook($id, $t,$applications) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEvalTrainingsDetails($id);
			}
		}
		
		if($arr = $this->model->getEvalDetails($id)) {
			$eval = $arr["eval"];
			$leistungen = $arr["leistungen"];
			$trainings = $trainings;
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/handbook_cover.php';
				$html .= ob_get_contents();
			ob_end_clean();
			ob_start();
				include 'view/print.php';
				$html .= ob_get_contents();
			ob_end_clean();
			// objectives
			$evalsObjectives = new EvalsObjectives("objectives");
			if($arrojs = $evalsObjectives->model->getList($id,"0")) {
				$ojs = $arrojs["objectives"];
				foreach ($ojs as $oj) {
					if($arr = $evalsObjectives->model->getDetails($oj->id)) {
						$objective = $arr["objective"];
						//$oj = $arr["oj"];
						$task = $arr["task"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/objectives/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
			}
			$evalsComments = new EvalsComments("comments");
			if($arrcoms = $evalsComments->model->getList($id,"0")) {
				$coms = $arrcoms["comments"];
				foreach ($coms as $com) {
					if($arr = $evalsComments->model->getDetails($com->id)) {
						$comment = $arr["comment"];
						$com = $arr["com"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/comments/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
			}
			$title = $eval->title . " - " . $lang["EVAL_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EVAL_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinEval($id) {
		if($id != "undefined") {
			return $this->model->checkinEval($id);
		} else {
			return true;
		}
	}

	function getEvalSend($id) {
		global $lang;
		if($arr = $this->model->getEvalDetails($id, 'prepareSendTo')) {
			$eval = $arr["eval"];
			$leistungen = $arr["leistungen"];
			$form_url = $this->form_url;
			$request = "sendEvalDetails";
			$to = "";
			$cc = "";
			$subject = $eval->title;
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


	function sendEvalDetails($id,$to,$cc,$subject,$body,$applications) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEvalTrainingsDetails($id);
			}
		}
		if($arr = $this->model->getEvalDetails($id)) {
			$eval = $arr["eval"];
			$leistungen = $arr["leistungen"];
			$trainings = $trainings;
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $eval->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EVAL"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("evals",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newEval($id,$cid) {
		$retval = $this->model->newEval($id,$cid);
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


	function setEvalDetails($id,$startdate,$enddate,$protocol,$protocol2,$protocol3,$protocol4,$protocol5,$protocol6,$folder,$number,$kind,$area,$department,$dob,$coo,$family,$languages,$languages_foreign,$street_private,$city_private,$zip_private,$phone_private,$email_private,$education) {
		$retval = $this->model->setEvalDetails($id,$startdate,$enddate,$protocol,$protocol2,$protocol3,$protocol4,$protocol5,$protocol6,$folder,$number,$kind,$area,$department,$dob,$coo,$family,$languages,$languages_foreign,$street_private,$city_private,$zip_private,$phone_private,$email_private,$education);
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


	function binEval($id) {
		$retval = $this->model->binEval($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreEval($id) {
		$retval = $this->model->restoreEval($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteEval($id) {
		$retval = $this->model->deleteEval($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveEval($id,$startdate,$movedays) {
		$retval = $this->model->moveEval($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getEvalFolderDialog($field,$title) {
		$retval = $this->model->getEvalFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getEvalStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getEvalDialog($field,$sql) {
		$retval = $this->model->getEvalDialog($field,$sql);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	

	function getEvalMoreDialog($field,$title) {
		$retval = $this->model->getEvalMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	function getEvalCatDialog($field,$title) {
		$retval = $this->model->getEvalCatDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getEvalCatMoreDialog($field,$title) {
		$retval = $this->model->getEvalCatMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
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
	
	
	function getObjectives($id) {
		global $lang;
		return $this->model->getObjectives($id);
	}

	
	function getChartPerformance($id,$what,$print=0,$type=0,$tendency=1, $offset) {
		global $lang;
		if($chart = $this->model->getChartPerformance($id,$what,1,$tendency,$offset)) {
			if($print == 1) {
				include 'view/chart_print.php';
			} else {
				include 'view/chart.php';
			}
		} else {
			include CO_INC .'/view/default.php';
		}
	}

	
	
	function getEvalsHelp() {
		global $lang;
		$data["file"] = $lang["EVAL_HELP"];
		$data["app"] = "evals";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getEvalsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["EVAL_FOLDER_HELP"];
		$data["app"] = "evals";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $evals;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $evals;
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
	  /*if($this->model->isEvalOwner($session->uid)) {
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
	
	/*function getEvalTitle($id){
		$title = $this->model->getEvalTitle($id);
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


	function getEvalsSearch($term,$exclude) {
		$search = $this->model->getEvalsSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedEvals($id) {
		$retval = $this->model->saveLastUsedEvals($id);
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
   
}

$evals = new Evals("evals");
?>