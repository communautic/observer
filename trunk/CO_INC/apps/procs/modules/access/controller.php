<?php
class ProcsAccess extends Procs {
	var $module;
	
	// get all available apps
	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/procs/modules/$name/";
			$this->model = new ProcsAccessModel();
			$this->binDisplay = false;
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
		$data["title"] = "";
		return $system->json_encode($data);
	}
	
	function getDetails($id,$fid=0) {
		global $lang;
		if($access = $this->model->getDetails($id,$fid)) {
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function setDetails($pid,$admins,$guests) {
		$retval = $this->model->setDetails($pid,$admins,$guests);
		if($retval){
			 return '{ "action": "edit" , "id": "' . $retval . '"}';
		  } else{
			 return "error";
		  }
	}


	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PROC_ACCESS_HELP"];
		$data["app"] = "procs";
		$data["module"] = "/modules/access";
		$this->openHelpPDF($data);
	}
	
	function getListArchive($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$access = $arr["access"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = "";
		return $system->json_encode($data);
	}
	
	function getDetailsArchive($id) {
		global $lang;
		if($access = $this->model->getDetails($id)) {
			include('view/edit_archive.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}

}

$procsAccess = new ProcsAccess("access");
?>