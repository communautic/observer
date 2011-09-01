<?php

class BrainstormsMeetings extends Brainstorms {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/brainstorms/modules/$name/";
			$this->model = new BrainstormsMeetingsModel();
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
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["BRAINSTORM_MEETING_ACTION_NEW"];
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
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["BRAINSTORM_PRINT_MEETING"];
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
		if($arr = $this->model->getDetails($id)) {
			$meeting = $arr["meeting"];
			$task = $arr["task"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $meeting->participants;
			$cc = "";
			$subject = $meeting->title;
			$variable = "";
			
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
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
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["BRAINSTORM_PRINT_MEETING"];
		$attachment = CO_PATH_PDF . "/" . $title . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("brainstorms_meetings",$id,$to,$subject,$body);
		
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
	

	function setDetails($pid,$id,$title,$meetingdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$task_id,$task_title,$task_text,$task,$task_sort,$documents,$meeting_access,$meeting_access_orig,$meeting_status,$meeting_status_date) {
		if($arr = $this->model->setDetails($pid,$id,$title,$meetingdate,$start,$end,$location,$location_ct,$participants,$participants_ct,$management,$management_ct,$task_id,$task_title,$task_text,$task,$task_sort,$documents,$meeting_access,$meeting_access_orig,$meeting_status,$meeting_status_date)){
			if($arr["what"] == "edit") {
				return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $meeting_access . '", "status": "' . $meeting_status . '"}';
			} else {
				return '{ "action": "reload" , "id": "' . $arr["id"] . '"}';
			}
		} else{
			return "error";
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
		$data["file"] =  $lang["BRAINSTORM_MEETING_HELP"];
		$data["app"] = "brainstorms";
		$data["module"] = "/modules/meetings";
		$this->openHelpPDF($data);
	}

}

$brainstormsMeetings = new BrainstormsMeetings("meetings");
?>