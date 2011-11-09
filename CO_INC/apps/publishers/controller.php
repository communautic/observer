<?php

//include_once("lang/" . $session->userlang . ".php");

class Publishers extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new PublishersModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			
			if (!$session->isSysadmin()) {
				$this->canView = $this->model->getViewPerms($session->uid);
				$this->canEdit = $this->model->getEditPerms($session->uid);
				$this->canAccess = array_merge($this->canView,$this->canEdit);
			}
	}


	function getFolderList($sort) {
		global $system, $lang;
		$arr = $this->model->getFolderList($sort);
		$folders = $arr["folders"];
		ob_start();
			include('view/folders_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["access"] = $arr["access"];
		$data["title"] = $lang["PUBLISHER_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$publishers = $arr["publishers"];
			ob_start();
			include 'view/folder_edit.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}


	function printFolderDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$publishers = $arr["publishers"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PUBLISHER_FOLDER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function getFolderSend($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$publishers = $arr["publishers"];	
			$form_url = $this->form_url;
			$request = "sendFolderDetails";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendFolderDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$publishers = $arr["publishers"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PUBLISHER_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $title . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("publishers",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"publishers","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$publisherstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$publisherstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $publisherstatus . '", "id": "' . $id . '" }';
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


	function restoreFolder($id) {
		$retval = $this->model->restoreFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function deleteFolder($id) {
		$retval = $this->model->deleteFolder($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function getPublisherList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getPublisherList($id,$sort);
		$publishers = $arr["publishers"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["PUBLISHER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getPublisherDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getPublisherDetails($id)) {
			$publisher = $arr["publisher"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return $system->json_encode($data);
		}
		else {
			ob_start();
				include CO_INC .'/view/default.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return $system->json_encode($data);
		}
	}


	function getDates($id) {
		
		if($publisher = $this->model->getDates($id)) {
			return json_encode($publisher);
		}
	}


	function printPublisherDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getPublisherDetails($id)) {
			$publisher = $arr["publisher"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $publisher->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PUBLISHER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printPublisherHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getPublisherDetails($id)) {
			$publisher = $arr["publisher"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/handbook_cover.php';
				$html .= ob_get_contents();
			ob_end_clean();
			ob_start();
				include 'view/print.php';
				$html .= ob_get_contents();
			ob_end_clean();
			// phases
			$phasescont = new PublishersPhases("phases");
			foreach ($phases as $phase) {
				if($arr = $phasescont->model->getDetails($phase->id,$num[$phase->id])) {
					$phase = $arr["phase"];
					$task = $arr["task"];
					$sendto = $arr["sendto"];
					ob_start();
						include 'modules/phases/view/print.php';
						$html .= ob_get_contents();
					ob_end_clean();
				}
			}
			// documents
			$publishersDocuments = new PublishersDocuments("documents");
			if($arrdocs = $publishersDocuments->model->getList($id,"0")) {
				$docs = $arrdocs["documents"];
				foreach ($docs as $doc) {
					if($arr = $publishersDocuments->model->getDetails($doc->id)) {
						$document = $arr["document"];
						$doc = $arr["doc"];
						$sendto = $arr["sendto"];
						ob_start();
							include 'modules/documents/view/print.php';
							$html .= ob_get_contents();
						ob_end_clean();
					}
				}
				$html .= '<div style="page-break-after:always;">&nbsp;</div>';
			}
			// controlling
			$publishersControlling = new PublishersControlling("controlling");
			if($cont = $publishersControlling->model->getDetails($id)) {
				$tit = $publisher->title;
				ob_start();
					include 'modules/controlling/view/print.php';
					$html .= ob_get_contents();
				ob_end_clean();
			}
			$title = $publisher->title . " - " . $lang["PUBLISHER_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PUBLISHER_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinPublisher($id) {
		if($id != "undefined") {
			return $this->model->checkinPublisher($id);
		} else {
			return true;
		}
	}

	function getPublisherSend($id) {
		global $lang;
		if($arr = $this->model->getPublisherDetails($id)) {
			$publisher = $arr["publisher"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			
			$form_url = $this->form_url;
			$request = "sendPublisherDetails";
			$to = $publisher->team;
			$cc = "";
			$subject = $publisher->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendPublisherDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getPublisherDetails($id)) {
			$publisher = $arr["publisher"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $publisher->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PUBLISHER"];
		$attachment = CO_PATH_PDF . "/" . $title . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("publishers",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newPublisher($id) {
		$retval = $this->model->newPublisher($id);
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


	function setPublisherDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder,$status,$status_date) {
		$retval = $this->model->setPublisherDetails($id,$title,$startdate,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder,$status,$status_date);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '", "status": "' . $status . '"}';
		  } else{
			 return "error";
		  }
	}


	function binPublisher($id) {
		$retval = $this->model->binPublisher($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restorePublisher($id) {
		$retval = $this->model->restorePublisher($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deletePublisher($id) {
		$retval = $this->model->deletePublisher($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function movePublisher($id,$startdate,$movedays) {
		$retval = $this->model->movePublisher($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getPublisherFolderDialog($field,$title) {
		$retval = $this->model->getPublisherFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getPublisherStatusDialog() {
		global $lang;
		include 'view/dialog_publisher_status.php';
	}


	function getAccessDialog() {
		global $lang;
		include 'view/dialog_access.php';
	}


	// STATISTICS
	function getChartFolder($id,$what,$print=0,$type=0) {
		global $lang;
		if($chart = $this->model->getChartFolder($id,$what)) {
				if($type == 1) {
					if($print == 1) {
						include 'view/chart_status_print.php';
					} else {
						include 'view/chart_status.php';
					}
				} else {
					if($print == 1) {
						include 'view/chart_print.php';
					} else {
						include 'view/chart.php';
					}
				}
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function getPublishersHelp() {
		global $lang;
		$data["file"] = $lang["PUBLISHER_HELP"];
		$data["app"] = "publishers";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getPublishersFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["PUBLISHER_FOLDER_HELP"];
		$data["app"] = "publishers";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $publishers;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $publishers;
		if($arr = $this->model->emptyBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	// User Access
	function isAdmin(){
	  global $session;
	  /*if($this->model->isPublisherOwner($session->uid)) {
	  	return true;
	  }*/
	  $canEdit = $this->model->getEditPerms($session->uid);
	  return !empty($canEdit);
   }
   
   function isGuest(){
	  global $session;
	  $canView = $this->model->getViewPerms($session->uid);
	  return !empty($canView);
   }

}

$publishers = new Publishers("publishers");
?>