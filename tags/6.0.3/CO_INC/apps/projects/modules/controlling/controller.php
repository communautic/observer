<?php

class Controlling {
	var $module;
	
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new ControllingModel();
			$this->binDisplay = false;
	}
	
	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$controlling = $arr["controlling"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getDetails($id,$pid) {
		global $lang;
		if($controlling = $this->model->getDetails($pid)) {
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function setDetails($id,$title,$controllingdate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task) {
		$retval = $this->model->setDetails($id,$title,$controllingdate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task);
		if($retval){
			 return '{ "action": "edit" , "id": "' . $retval . '"}';
		  } else{
			 return "error";
		  }
	}

	function getNew($id) {
		$controlling = $this->model->getNew($id);
		include 'view/new.php';
	}
	
	function createNew($id,$title,$controlling_date) {
		$retval = $this->model->createNew($id,$title,$controlling_date);
		if($retval){
			 return '{ "what": "controlling" , "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binControlling($id) {
		$retval = $this->model->binControlling($id);
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
	
	function insertTask($num) {
		//$task = $this->model->insertDocumentTask($start,$end);
		include 'view/task_new.php';
	}
	
	
	function getChart($id,$what) {
		if($chart = $this->model->getChart($id,$what)) {
				include CO_INC .'/apps/projects/view/chart.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
}

$controlling = new Controlling("controlling");
?>