<?php

//include_once("lang/" . $session->userlang . ".php");

class Projects extends Controller {
	
	// get all available apps
	function __construct($name) {
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ProjectsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
	}
	
	function getFolderList($sort) {
		global $system;
		$arr = $this->model->getFolderList($sort);
		$folders = $arr["folders"];
		ob_start();
			include('view/folders_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getFolderDetails($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$projects = $arr["projects"];
				include 'view/folder_edit.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}


	function printFolderDetails($id, $t) {
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$projects = $arr["projects"];
			
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function newFolder() {
		$retval = $this->model->newFolder();
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function setFolderDetails($id,$title,$projectstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$projectstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $projectstatus . '", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binFolder($id) {
		$retval = $this->model->binFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function getProjectList($id,$sort) {
		global $system;
		$arr = $this->model->getProjectList($id,$sort);
		$projects = $arr["projects"];
		ob_start();
			include('view/projects_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}

	function getProjectDetails($id) {
		global $lang;
		if($arr = $this->model->getProjectDetails($id)) {
			$project = $arr["project"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			include 'view/project_edit.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function getDates($id) {
		
		if($project = $this->model->getDates($id)) {
			return json_encode($project);
		}
	}


	function printProjectDetails($id, $t) {
		global $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getProjectDetails($id)) {
			$project = $arr["project"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			
			ob_start();
				include 'view/project_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $project->title;
		}
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function newProject($id) {
		$retval = $this->model->newProject($id);
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
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
	
	/*function newProject($id,$title,$startdate,$enddate,$management,$management_ct,$team,$team_ct,$protocol,$projectfolder,$status,$status_date) {
		$retval = $this->model->newProject($id,$title,$startdate,$enddate,$management,$management_ct,$team,$team_ct,$protocol,$projectfolder,$status,$status_date);
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}*/
	
	/*function newProject($id,$title,$startdate,$enddate,$management,$team,$ordered_by,$ordered_on,$project_partner,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date) {
		$retval = $this->model->newProject($id,$title,$startdate,$enddate,$management,$team,$ordered_by,$ordered_on,$project_partner,$protocol,$projectstatus,$planned_date,$inprogress_date,$finished_date);
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}*/
	
	
	function setProjectDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$projectfolder,$status,$status_date) {
		$retval = $this->model->setProjectDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$projectfolder,$status,$status_date);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binProject($id) {
		$retval = $this->model->binProject($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	
	//function moveProject($id,$title,$startdate,$enddate,$management,$management_ct,$team,$team_ct,$protocol,$projectfolder,$status,$status_date,$movedays) {
	function moveProject($id,$startdate,$movedays) {
		$retval = $this->model->moveProject($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function getProjectFolderDialog($field,$title) {
		$retval = $this->model->getProjectFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getProjectStatusDialog() {
		global $lang;
		include 'view/dialog_project_status.php';
	}
	
	function getAccessDialog() {
		global $lang;
		include 'view/dialog_access.php';
	}
	
	// STATISTICS
	
	function getChartFolder($id,$what) {
		if($chart = $this->model->getChartFolder($id,$what)) {
				include 'view/chart.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}


	function getBin() {
		global $lang;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			$folders = $arr["folders"];
			//$projects = $arr["projects"];
			//$phases = $arr["phases"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	
}

$projects = new Projects("projects");
?>