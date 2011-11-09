<?php
class PublishersAccess extends Publishers {
	var $module;
	
	// get all available apps
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/publishers/modules/$name/";
			$this->model = new PublishersAccessModel();
			$this->binDisplay = false;
	}
	
	function getList($sort) {
		global $system;
		$arr = $this->model->getList($sort);
		$access = $arr["access"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = "";
		return $system->json_encode($data);
	}
	
	function getDetails() {
		global $lang;
		if($access = $this->model->getDetails()) {
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function setDetails($admins,$guests) {
		$retval = $this->model->setDetails($admins,$guests);
		if($retval){
			 return '{ "action": "edit" , "id": "' . $retval . '"}';
		  } else{
			 return "error";
		  }
	}
	
	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PUBLISHER_ACCESS_HELP"];
		$data["app"] = "publishers";
		$data["module"] = "/modules/access";
		$this->openHelpPDF($data);
	}
	

}

$publishersAccess = new PublishersAccess("access");
?>