<?php
/*include_once("../../config.php");
include_once("config.php");
include_once("lang/" . $session->userlang . ".php");
include_once("model.php");*/

class Phonecalls {
	var $module;
	
	// get all available apps
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new PhonecallsModel();
	}
	
	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$phonecalls = $arr["phonecalls"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getDetails($id) {
		if($phonecall = $this->model->getDetails($id)) {
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function setDetails($id,$title,$phonecalldate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task) {
		$retval = $this->model->setDetails($id,$title,$phonecalldate,$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task);
		if($retval){
			 return '{ "action": "edit" , "id": "' . $retval . '"}';
		  } else{
			 return "error";
		  }
	}

	function getNew($id) {
		$phonecall = $this->model->getNew($id);
		include 'view/new.php';
	}
	
	function createNew($id,$title,$phonecall_date) {
		$retval = $this->model->createNew($id,$title,$phonecall_date);
		if($retval){
			 return '{ "what": "phonecall" , "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binPhonecall($id) {
		$retval = $this->model->binPhonecall($id);
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

$phonecalls = new Phonecalls("phonecalls");
?>