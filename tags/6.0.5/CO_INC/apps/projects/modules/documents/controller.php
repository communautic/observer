<?php
/*include_once("../../config.php");
include_once("config.php");
include_once("lang/" . $session->userlang . ".php");
include_once("model.php");*/

class Documents extends Projects {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/projects/modules/$name/";
			$this->model = new DocumentsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system;
		$arr = $this->model->getList($id,$sort);
		$documents = $arr["documents"];
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
			$document = $arr["document"];
			$doc = $arr["doc"];
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
			$document = $arr["document"];
			$doc = $arr["doc"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $document->title;
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
			$document = $arr["document"];
			$doc = $arr["doc"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $document->title;
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
			$document = $arr["document"];
			$doc = $arr["doc"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $document->title;
		}
		$attachment = CO_PATH_PDF . "/" . $title . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		$attachment_array = "";
		foreach($doc as $value) {
			$attachment_array[] = array("tempname" => $value->tempname, "filename" => $value->filename);
			
		}
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment,$attachment_array);
	}


	function setDetails($id,$title,$document_access) {
		$retval = $this->model->setDetails($id,$title,$document_access);
		if($retval){
			return '{ "action": "edit" , "id": "' . $retval . '", "access": "' . $document_access . '"}';
		} else{
			return "error";
		}
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			return '{ "what": "document" , "action": "new", "id": "' . $retval . '" }';
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


	function binDocument($id) {
		$retval = $this->model->binDocument($id);
		if($retval){
			 return "true";
		} else{
			 return "error";
		}
	}


	function restoreDocument($id) {
		$retval = $this->model->restoreDocument($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function deleteDocument($id) {
		$retval = $this->model->deleteDocument($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function getDocumentsDialog($request,$field,$append,$title,$sql,$id) {
		$list = $this->model->getDocumentsDialog($request,$field,$append,$title,$sql,$id);
		include 'view/dialog.php';
	}


	function downloadDocument($id) {
		$this->model->downloadDocument($id);
	}


	function getDocContext($id,$field) {
		global $lang;
		if($arr = $this->model->getDocContext($id,$field)) {
			$document = $arr["document"];
			$doc = $arr["doc"];
			include 'view/context.php';
		}
	}


	function binDocItem($id) {
		$retval = $this->model->binDocItem($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function restoreFile($id) {
		$retval = $this->model->restoreFile($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteFile($id) {
		$retval = $this->model->deleteFile($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}

}

$documents = new Documents("documents");
?>