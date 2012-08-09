<?php

//include_once("lang/" . $session->userlang . ".php");

class Complaints extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ComplaintsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
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
		$data["title"] = $lang["COMPLAINT_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$complaints = $arr["complaints"];
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
			$complaints = $arr["complaints"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_COMPLAINT_FOLDER"];
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
			$complaints = $arr["complaints"];	
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
			$complaints = $arr["complaints"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_COMPLAINT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("complaints",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"complaints","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$complaintstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$complaintstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $complaintstatus . '", "id": "' . $id . '" }';
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


	function getComplaintList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getComplaintList($id,$sort);
		$complaints = $arr["complaints"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["COMPLAINT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getComplaintDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getComplaintDetails($id)) {
			$complaint = $arr["complaint"];
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


	function printComplaintDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getComplaintDetails($id)) {
			$complaint = $arr["complaint"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $complaint->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_COMPLAINT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printComplaintHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getComplaintDetails($id)) {
			$complaint = $arr["complaint"];
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
			$phasescont = new ComplaintsPhases("phases");
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
			$complaintsDocuments = new ComplaintsDocuments("documents");
			if($arrdocs = $complaintsDocuments->model->getList($id,"0")) {
				$docs = $arrdocs["documents"];
				foreach ($docs as $doc) {
					if($arr = $complaintsDocuments->model->getDetails($doc->id)) {
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
			$complaintsControlling = new ComplaintsControlling("controlling");
			if($cont = $complaintsControlling->model->getDetails($id)) {
				$tit = $complaint->title;
				ob_start();
					include 'modules/controlling/view/print.php';
					$html .= ob_get_contents();
				ob_end_clean();
			}
			$title = $complaint->title . " - " . $lang["COMPLAINT_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_COMPLAINT_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinComplaint($id) {
		if($id != "undefined") {
			return $this->model->checkinComplaint($id);
		} else {
			return true;
		}
	}

	function getComplaintSend($id) {
		global $lang;
		if($arr = $this->model->getComplaintDetails($id, 'prepareSendTo')) {
			$complaint = $arr["complaint"];
			$form_url = $this->form_url;
			$request = "sendComplaintDetails";
			$to = $complaint->sendtoTeam;
			$cc = "";
			$subject = $complaint->title;
			$variable = "";
			$data["error"] = 0;
			$data["error_message"] = "";
			if($complaint->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $complaint->sendtoTeamNoEmail;
			}
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function sendComplaintDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getComplaintDetails($id)) {
			$complaint = $arr["complaint"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $complaint->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_COMPLAINT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("complaints",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newComplaint($id) {
		$retval = $this->model->newComplaint($id);
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


	function setComplaintDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder,$complaint,$complaint_more,$complaint_cat,$complaint_cat_more,$product,$product_desc,$charge,$number) {
		$retval = $this->model->setComplaintDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder,$complaint,$complaint_more,$complaint_cat,$complaint_cat_more,$product,$product_desc,$charge,$number);
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


	function binComplaint($id) {
		$retval = $this->model->binComplaint($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreComplaint($id) {
		$retval = $this->model->restoreComplaint($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteComplaint($id) {
		$retval = $this->model->deleteComplaint($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveComplaint($id,$startdate,$movedays) {
		$retval = $this->model->moveComplaint($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getComplaintFolderDialog($field,$title) {
		$retval = $this->model->getComplaintFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getComplaintStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getComplaintDialog($field,$title) {
		$retval = $this->model->getComplaintDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	

	function getComplaintMoreDialog($field,$title) {
		$retval = $this->model->getComplaintMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	function getComplaintCatDialog($field,$title) {
		$retval = $this->model->getComplaintCatDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getComplaintCatMoreDialog($field,$title) {
		$retval = $this->model->getComplaintCatMoreDialog($field,$title);
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
	
	
	function getComplaintsHelp() {
		global $lang;
		$data["file"] = $lang["COMPLAINT_HELP"];
		$data["app"] = "complaints";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getComplaintsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["COMPLAINT_FOLDER_HELP"];
		$data["app"] = "complaints";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $complaints;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $complaints;
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
	  /*if($this->model->isComplaintOwner($session->uid)) {
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
	
	/*function getComplaintTitle($id){
		$title = $this->model->getComplaintTitle($id);
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
   
	function getGlobalSearch($term) {
		$search = $this->model->getGlobalSearch($term);
		return $search;
	}
   
}

$complaints = new Complaints("complaints");
?>