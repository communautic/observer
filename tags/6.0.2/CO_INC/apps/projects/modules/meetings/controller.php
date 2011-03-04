<?php

class Meetings {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new MeetingsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$meetings = $arr["meetings"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$meeting = $arr["meeting"];
			$task = $arr["task"];
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
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
	
	function getMeetingStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}

}

$meetings = new Meetings("meetings");
?>