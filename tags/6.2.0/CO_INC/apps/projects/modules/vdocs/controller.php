<?php

class VDocs extends Projects {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new VDocsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$vdocs = $arr["vdocs"];
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
			$vdoc = $arr["vdoc"];
			$sendto = $arr["sendto"];
			include('view/edit.php');
		} else {
			include CO_INC .'/view/default.php';
		}
	}


	function printDetails($id,$t) {
		global $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$vdoc = $arr["vdoc"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $vdoc->title;
		}
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
			$vdoc = $arr["vdoc"];
			$task = $arr["task"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $vdoc->participants;
			$cc = "";
			$subject = $vdoc->title;
			$variable = "";
			
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$vdoc = $arr["vdoc"];
			$task = $arr["task"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $vdoc->title;
		}
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("projects_vdocs",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function setDetails($pid,$id,$title,$content,$vdoc_access,$vdoc_access_orig) {
		if($arr = $this->model->setDetails($pid,$id,$title,$content,$vdoc_access,$vdoc_access_orig)){
			if($arr["what"] == "edit") {
				return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $vdoc_access . '"}';
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
			 return '{ "what": "vdoc" , "action": "new", "id": "' . $retval . '" }';
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


	function binVDoc($id) {
		$retval = $this->model->binVDoc($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreVDoc($id) {
		$retval = $this->model->restoreVDoc($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteVDoc($id) {
		$retval = $this->model->deleteVDoc($id);
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


}

$vdocs = new VDocs("vdocs");
?>