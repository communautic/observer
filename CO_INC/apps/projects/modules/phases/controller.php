<?php

class Phases {
	var $module;
	
	// get all available apps
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new PhasesModel();
	}
	
	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$phases = $arr["phases"];
		$num = $arr["num"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getDetails($id,$num) {
		global $lang;
		if($arr = $this->model->getDetails($id,$num)) {
			$phase = $arr["phase"];
			$task = $arr["task"];
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function setDetails($id,$title,$management,$management_ct,$team,$team_ct,$protocol,$documents,$phase_access,$phase_access_orig,$phase_status,$phase_status_date,$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task,$task_cat,$task_dependent) {
		if($arr = $this->model->setDetails($id,$title,$management,$management_ct,$team,$team_ct,$protocol,$documents,$phase_access,$phase_access_orig,$phase_status,$phase_status_date,$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task,$task_cat,$task_dependent)){
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


	function toggleIntern($id,$status) {
		$retval = $this->model->toggleIntern($id,$status);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function getPhaseTaskDialog() {
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


	function addTask($pid,$phid,$date,$cat) {
		global $lang;
		$task = $this->model->addTask($pid,$phid,$date,$cat);
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


	function getPhaseStatusDialog() {
		include 'view/dialog_status.php';
	}
	
}

$phases = new Phases("phases");
?>