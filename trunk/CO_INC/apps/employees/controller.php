<?php

//include_once("lang/" . $session->userlang . ".php");

class Employees extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new EmployeesModel();
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
		$data["title"] = $lang["EMPLOYEE_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$employees = $arr["employees"];
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
			$employees = $arr["employees"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EMPLOYEE_FOLDER"];
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
			$employees = $arr["employees"];	
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
			$employees = $arr["employees"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EMPLOYEE_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("employees",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"employees","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$employeestatus) {
		$retval = $this->model->setFolderDetails($id,$title,$employeestatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $employeestatus . '", "id": "' . $id . '" }';
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


	function getEmployeeList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getEmployeeList($id,$sort);
		$employees = $arr["employees"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["EMPLOYEE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getEmployeeDetails($id,$applications) {
		global $lang, $system;
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEmployeeTrainingsDetails($id);
			}
		}
		if($arr = $this->model->getEmployeeDetails($id)) {
			$employee = $arr["employee"];
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


	function printEmployeeDetails($id, $t,$applications) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEmployeeTrainingsDetails($id);
			}
		}
		if($arr = $this->model->getEmployeeDetails($id)) {
			$employee = $arr["employee"];
			$leistungen = $arr["leistungen"];
			$trainings = $trainings;
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $employee->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EMPLOYEE"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printEmployeeHandbook($id, $t,$applications) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEmployeeTrainingsDetails($id);
			}
		}
		
		if($arr = $this->model->getEmployeeDetails($id)) {
			$employee = $arr["employee"];
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
			$employeesObjectives = new EmployeesObjectives("objectives");
			if($arrojs = $employeesObjectives->model->getList($id,"0")) {
				$ojs = $arrojs["objectives"];
				foreach ($ojs as $oj) {
					if($arr = $employeesObjectives->model->getDetails($oj->id)) {
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
			$employeesComments = new EmployeesComments("comments");
			if($arrcoms = $employeesComments->model->getList($id,"0")) {
				$coms = $arrcoms["comments"];
				foreach ($coms as $com) {
					if($arr = $employeesComments->model->getDetails($com->id)) {
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
			$title = $employee->title . " - " . $lang["EMPLOYEE_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EMPLOYEE_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinEmployee($id) {
		if($id != "undefined") {
			return $this->model->checkinEmployee($id);
		} else {
			return true;
		}
	}

	function getEmployeeSend($id) {
		global $lang;
		if($arr = $this->model->getEmployeeDetails($id, 'prepareSendTo')) {
			$employee = $arr["employee"];
			$leistungen = $arr["leistungen"];
			$form_url = $this->form_url;
			$request = "sendEmployeeDetails";
			$to = "";
			$cc = "";
			$subject = $employee->title;
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


	function sendEmployeeDetails($id,$to,$cc,$subject,$body,$applications) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		$trainig_display = false;
		$trainings = array();
		foreach($applications as $app => $display) {
			if($app == 'trainings') {
				$trainig_display = true;
				$trainings = $this->model->getEmployeeTrainingsDetails($id);
			}
		}
		if($arr = $this->model->getEmployeeDetails($id)) {
			$employee = $arr["employee"];
			$leistungen = $arr["leistungen"];
			$trainings = $trainings;
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $employee->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_EMPLOYEE"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("employees",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newEmployee($id,$cid) {
		$retval = $this->model->newEmployee($id,$cid);
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


	function setEmployeeDetails($id,$startdate,$enddate,$protocol,$protocol2,$protocol3,$protocol4,$protocol5,$protocol6,$folder,$number,$kind,$area,$department,$dob,$coo,$family,$languages,$languages_foreign,$street_private,$city_private,$zip_private,$phone_private,$email_private,$education) {
		$retval = $this->model->setEmployeeDetails($id,$startdate,$enddate,$protocol,$protocol2,$protocol3,$protocol4,$protocol5,$protocol6,$folder,$number,$kind,$area,$department,$dob,$coo,$family,$languages,$languages_foreign,$street_private,$city_private,$zip_private,$phone_private,$email_private,$education);
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


	function binEmployee($id) {
		$retval = $this->model->binEmployee($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreEmployee($id) {
		$retval = $this->model->restoreEmployee($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteEmployee($id) {
		$retval = $this->model->deleteEmployee($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveEmployee($id,$startdate,$movedays) {
		$retval = $this->model->moveEmployee($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getEmployeeFolderDialog($field,$title) {
		$retval = $this->model->getEmployeeFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getEmployeeStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getEmployeeDialog($field,$sql) {
		$retval = $this->model->getEmployeeDialog($field,$sql);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	

	function getEmployeeMoreDialog($field,$title) {
		$retval = $this->model->getEmployeeMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	function getEmployeeCatDialog($field,$title) {
		$retval = $this->model->getEmployeeCatDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getEmployeeCatMoreDialog($field,$title) {
		$retval = $this->model->getEmployeeCatMoreDialog($field,$title);
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

	
	
	function getEmployeesHelp() {
		global $lang;
		$data["file"] = $lang["EMPLOYEE_HELP"];
		$data["app"] = "employees";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getEmployeesFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["EMPLOYEE_FOLDER_HELP"];
		$data["app"] = "employees";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $employees;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $employees;
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
	  /*if($this->model->isEmployeeOwner($session->uid)) {
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
	
	/*function getEmployeeTitle($id){
		$title = $this->model->getEmployeeTitle($id);
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


	function getEmployeesSearch($term,$exclude) {
		$search = $this->model->getEmployeesSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedEmployees($id) {
		$retval = $this->model->saveLastUsedEmployees($id);
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

$employees = new Employees("employees");
?>