<?php

//include_once("lang/" . $session->userlang . ".php");

class Projects extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ProjectsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			
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
		$data["title"] = $lang["PROJECT_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$projects = $arr["projects"];
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
			$projects = $arr["projects"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROJECT_FOLDER"];
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
			$projects = $arr["projects"];	
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
			$projects = $arr["projects"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROJECT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("projects",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"projects","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$projectstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$projectstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $projectstatus . '", "id": "' . $id . '" }';
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


	function getProjectList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getProjectList($id,$sort);
		$projects = $arr["projects"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["PROJECT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getProjectDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getProjectDetails($id)) {
			$project = $arr["project"];
			$phases = $arr["phases"];
			$num = $arr["num"];
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


	function getDates($id) {
		
		if($project = $this->model->getDates($id)) {
			return json_encode($project);
		}
	}


	function printProjectDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getProjectDetails($id)) {
			$project = $arr["project"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $project->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROJECT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printProjectHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getProjectDetails($id)) {
			$project = $arr["project"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/handbook_cover.php';
				$html .= ob_get_contents();
			ob_end_clean();
			ob_start();
				include 'view/print.php';
				$html .= ob_get_contents();
			ob_end_clean();
			// phases
			$phasescont = new ProjectsPhases("phases");
			foreach ($phases as $phase) {
				if($arr = $phasescont->model->getDetails($phase->id,$num[$phase->id])) {
					$phase = $arr["phase"];
					$task = $arr["task"];
					$sendto = $arr["sendto"];
					ob_start();
						include 'modules/phases/view/print.php';
						$html .= ob_get_contents();
					ob_end_clean();
				}
			}
			// documents
			$projectsDocuments = new ProjectsDocuments("documents");
			if($arrdocs = $projectsDocuments->model->getList($id,"0")) {
				$docs = $arrdocs["documents"];
				foreach ($docs as $doc) {
					if($arr = $projectsDocuments->model->getDetails($doc->id)) {
						$document = $arr["document"];
						$doc = $arr["doc"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/documents/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
				$html .= '<div style="page-break-after:always;">&nbsp;</div>';
			}
			// controlling
			$projectsControlling = new ProjectsControlling("controlling");
			if($cont = $projectsControlling->model->getDetails($id)) {
				$tit = $project->title;
				ob_start();
					include 'modules/controlling/view/print.php';
					$html .= ob_get_contents();
				ob_end_clean();
			}
			$title = $project->title . " - " . $lang["PROJECT_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROJECT_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinProject($id) {
		if($id != "undefined") {
			return $this->model->checkinProject($id);
		} else {
			return true;
		}
	}

	function getProjectSend($id) {
		global $lang;
		if($arr = $this->model->getProjectDetails($id)) {
			$project = $arr["project"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			
			$form_url = $this->form_url;
			$request = "sendProjectDetails";
			$to = $project->team;
			$cc = "";
			$subject = $project->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendProjectDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getProjectDetails($id)) {
			$project = $arr["project"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $project->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROJECT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("projects",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newProject($id) {
		$retval = $this->model->newProject($id);
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


	function setProjectDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder,$status,$status_date) {
		$retval = $this->model->setProjectDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder,$status,$status_date);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '", "status": "' . $status . '"}';
		  } else{
			 return "error";
		  }
	}


	function binProject($id) {
		$retval = $this->model->binProject($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreProject($id) {
		$retval = $this->model->restoreProject($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteProject($id) {
		$retval = $this->model->deleteProject($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveProject($id,$startdate,$movedays) {
		$retval = $this->model->moveProject($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getProjectFolderDialog($field,$title) {
		$retval = $this->model->getProjectFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getProjectStatusDialog() {
		global $lang;
		include 'view/dialog_project_status.php';
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
	
	
	function getProjectsHelp() {
		global $lang;
		$data["file"] = $lang["PROJECT_HELP"];
		$data["app"] = "projects";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getProjectsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["PROJECT_FOLDER_HELP"];
		$data["app"] = "projects";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $projects;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $projects;
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
	  /*if($this->model->isProjectOwner($session->uid)) {
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

	function getWidgetAlerts() {
		global $lang, $system;
		if($arr = $this->model->getWidgetAlerts()) {
			$reminders = $arr["reminders"];
			$kickoffs = $arr["kickoffs"];
			$alerts = $arr["alerts"];
			$notices = $arr["notices"];
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
	
	
	function markNoticeRead($pid) {
		global $lang, $system;
		$retval = $this->model->markNoticeRead($pid);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

}

$projects = new Projects("projects");
?>