<?php

class Access {
	var $module;
	
	// get all available apps
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new AccessModel();
	}
	
	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$access = $arr["access"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getDetails($id, $pid) {
		if($access = $this->model->getDetails($id,$pid)) {
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function setDetails($id,$title,$startdate,$enddate,$management,$team,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date,$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new,$task_startdate,$task_enddate,$task_id,$task_text,$task) {
		$retval = $this->model->setDetails($id,$title,$startdate,$enddate,$management,$team,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date,$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new,$task_startdate,$task_enddate,$task_id,$task_text,$task);
		if($retval){
			 return '{ "action": "edit" , "id": "' . $retval . '"}';
		  } else{
			 return "error";
		  }
	}

	function getNew($id) {
		//$access = $this->model->getNew($id);
		include 'view/new.php';
	}
	
	function createNew($id,$title,$startdate,$enddate,$management,$team,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date,$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new) {
		$retval = $this->model->createNew($id,$title,$startdate,$enddate,$management,$team,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date,$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new);
		if($retval){
			 return '{ "what": "access" , "action": "new", "id": "' . $retval . '" }';
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
	
	function binAccess($id) {
		$retval = $this->model->binAccess($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function insertTask($start,$end,$num) {
		//$task = $this->model->insertAccessTask($start,$end);
		include 'view/task_new.php';
	}
	
}

$access = new Access("access");
?>