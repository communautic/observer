<?php

class ProjectsMeetings extends Projects {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new ProjectsMeetingsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$meetings = $arr["meetings"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PROJECT_MEETING_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$meeting = $arr["meeting"];
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


	function printDetails($id,$t) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$meeting = $arr["meeting"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $meeting->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROJECT_PRINT_MEETING"];
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
			$meeting = $arr["meeting"];
			$task = $arr["task"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $meeting->sendtoTeam;
			$cc = "";
			$subject = $meeting->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			if($meeting->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $meeting->sendtoTeamNoEmail;
			}
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
			$meeting = $arr["meeting"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $meeting->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROJECT_PRINT_MEETING"];
		$attachment = CO_PATH_PDF . "/" .$this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("projects_meetings",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinMeeting($id) {
		if($id != "undefined") {
			return $this->model->checkinMeeting($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$meetingdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$task_id,$task_title,$task_text,$task,$task_sort,$documents,$meeting_access,$meeting_access_orig) {
		if($retval = $this->model->setDetails($pid,$id,$title,$meetingdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$task_id,$task_title,$task_text,$task,$task_sort,$documents,$meeting_access,$meeting_access_orig)){
			return '{ "id": "' . $id . '", "access": "' . $meeting_access . '"}';
		} else{
			return "error";
		}
	}


	function updateStatus($id,$date,$status) {
		$arr = $this->model->updateStatus($id,$date,$status);
		if($arr["what"] == "edit") {
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "status": "' . $status . '"}';
		} else {
			return '{ "action": "reload" , "id": "' . $arr["id"] . '"}';
		}
	}

	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "meeting" , "action": "new", "id": "' . $retval . '" }';
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


	function binMeeting($id) {
		$retval = $this->model->binMeeting($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreMeeting($id) {
		$retval = $this->model->restoreMeeting($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteMeeting($id) {
		$retval = $this->model->deleteMeeting($id);
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
		$task = $this->model->addTask($mid,$num,$sort);
		$meeting->canedit = 1;
		foreach($task as $value) {
			$checked = '';
			if($value->status == 1) {
				$checked = ' checked="checked"';
			}
			include 'view/task.php';
		}
	}
	

	function sortItems($task) {
		$retval = $this->model->sortItems($task);
			if($retval){
			 return 'true';
		  } else{
			 return "error";
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
	
	function restoreMeetingTask($id) {
		$retval = $this->model->restoreMeetingTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteMeetingTask($id) {
		$retval = $this->model->deleteMeetingTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getMeetingStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PROJECT_MEETING_HELP"];
		$data["app"] = "projects";
		$data["module"] = "/modules/meetings";
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

	function getProjectsDialog() {
		global $system, $lang;
		$projects = $this->model->getLast10Projects();
		include('view/dialog_copy.php');
	}
	
	
	function copyMeeting($pid,$phid) {
		global $lang;
		$project = $this->model->copyMeeting($pid,$phid);
		//return $project;
		return json_encode($project);
	}
	
	function getListArchive($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getListArchive($id,$sort);
		$meetings = $arr["meetings"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PROJECT_MEETING_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetailsArchive($id) {
		global $lang;
		if($arr = $this->model->getDetailsArchive($id)) {
			$meeting = $arr["meeting"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit_archive.php';
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

}

$projectsMeetings = new ProjectsMeetings("meetings");
?>