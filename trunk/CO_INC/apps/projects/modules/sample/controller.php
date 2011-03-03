<?php
/*include_once("../../config.php");
include_once("config.php");
include_once("lang/" . $session->userlang . ".php");
include_once("model.php");*/

class Sample {
	var $module;
	
	// get all available apps
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new SampleModel();
			$this->binDisplay = true;
	}
	
	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$samples = $arr["samples"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getDetails($id) {
		include('view/edit.php');
		/*if($arr = $this->model->getDetails($id)) {
			$sample = $arr["sample"];
			$task = $arr["task"];
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}*/
	}
	
	function setDetails($id,$title,$sampledate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task) {
		$retval = $this->model->setDetails($id,$title,$sampledate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task);
		if($retval){
			 return '{ "action": "edit" , "id": "' . $retval . '"}';
		  } else{
			 return "error";
		  }
	}

	function getNew($id) {
		$sample = $this->model->getNew($id);
		include 'view/new.php';
	}
	
	function createNew($id,$title,$sample_date) {
		$retval = $this->model->createNew($id,$title,$sample_date);
		if($retval){
			 return '{ "what": "sample" , "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binSample($id) {
		$retval = $this->model->binSample($id);
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
	
}

$samples = new Sample("samples");
?>