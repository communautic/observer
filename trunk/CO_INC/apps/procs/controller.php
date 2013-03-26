<?php

//include_once("lang/" . $session->userlang . ".php");

class Procs extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ProcsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			$this->contactsDisplay = true; // list access status on contact page
			
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
		$data["title"] = $lang["PROC_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$procs = $arr["procs"];
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
		global $lang, $system;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$procs = $arr["procs"];
			
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


	function getFolderSend($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$procs = $arr["procs"];
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
			$procs = $arr["procs"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROC_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("forums",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"procs","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$procstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$procstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $procstatus . '", "id": "' . $id . '" }';
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


	function getProcList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getProcList($id,$sort);
		$procs = $arr["procs"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["PROC_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getProcDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getProcDetails($id)) {
			$proc = $arr["proc"];
			$notes = $arr["notes"];
			ob_start();
				include 'view/edit.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return json_encode($data);
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
		
		if($proc = $this->model->getDates($id)) {
			return json_encode($proc);
		}
	}
	
	
	function printProcMindmap($title,$text,$width,$height) {
		global $lang;
		ob_start();
			include(CO_INC . "/view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();		
		$footer = "</body></html>";
        $html = $header . $text . $footer;
		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		/*$dompdf->set_paper('a4', 'portrait');  change 'a4' to whatever you want 
         breite, höhe pixel dividiert durch 96 * 72*/
        $dompdf->set_paper( array(0,0, $width / 96 * 72, $height / 96 * 72), "portrait" );
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}

	function printProcDetails($id, $t) {
		global $session,$date,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getProcPrintDetails($id)) {
			$proc = $arr["proc"];
			$notes = $arr["notes"];
					
					$proc["page_width"] = $proc["css_width"]+245+300;
					$proc["page_height"] = $proc["css_height"]+200;
					if($proc["page_width"] < 896) {
						$proc["page_width"] = 896;
					}
					if($proc["page_height"] < 595) {
						$proc["page_height"] = 595;
					}
					
					ob_start();
					include('view/print.php');
						$html = ob_get_contents();
					ob_end_clean();
					$title = $proc["title"];
					
					
					$this->printProcMindmap($title,$html,$proc["page_width"],$proc["page_height"]);
					
		}
	}

	
	function checkinProc($id) {
		if($id != "undefined") {
			return $this->model->checkinProc($id);
		} else {
			return true;
		}
	}

	function getProcSend($id) {
		global $lang;
		if($arr = $this->model->getProcDetails($id)) {
			$proc = $arr["proc"];
			$notes = $arr["notes"];
			
			$form_url = $this->form_url;
			$request = "sendProcDetails";
			$to = "";
			$cc = "";
			$subject = $proc->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendProcDetails($id,$to,$cc,$subject,$body) {
		global $date,$session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getProcPrintDetails($id)) {
			$proc = $arr["proc"];
			$notes = $arr["notes"];
			
			$proc["page_width"] = $proc["css_width"]+245+300;
					$proc["page_height"] = $proc["css_height"]+200;
					if($proc["page_width"] < 896) {
						$proc["page_width"] = 896;
					}
					if($proc["page_height"] < 595) {
						$proc["page_height"] = 595;
					}
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $proc["title"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROC"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->saveTimeline($title,$html,$attachment,$proc["page_width"],$proc["page_height"]);
		
		// write sento log
		$this->writeSendtoLog("procs",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newProc($id) {
		$retval = $this->model->newProc($id);
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function newProcNote($id,$x,$y,$z,$what) {
		$retval = $this->model->newProcNote($id,$x,$y,$z,$what);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function saveProcNote($id,$title,$text) {
		$retval = $this->model->saveProcNote($id,$title,$text);
		if($retval){
			 $text = stripslashes($text);
			 return nl2br($text);
		  } else{
			 return "error";
		  }
	}
	
	/*function binProcNote($id) {
		$retval = $this->model->binProcNote($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}*/

	function deleteProcNote($id) {
		$retval = $this->model->deleteProcNote($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreItem($id) {
		$retval = $this->model->restoreItem($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function saveItemStyle($id,$shape,$color) {
		$retval = $this->model->saveItemStyle($id,$shape,$color);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteItem($id) {
		$retval = $this->model->deleteItem($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function updateNotePosition($id,$x,$y,$z) {
		$retval = $this->model->updateNotePosition($id,$x,$y,$z);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}


	function updateNoteSize($id,$w,$h) {
		$retval = $this->model->updateNoteSize($id,$w,$h);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	
	/*function setProcNoteToggle($id,$t) {
		$retval = $this->model->setProcNoteToggle($id,$t);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}*/


	function createDuplicate($id) {
		$retval = $this->model->createDuplicate($id);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function setProcDetails($id,$title,$folder) {
		$retval = $this->model->setProcDetails($id,$title,$folder);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '", "status": "0"}';
		  } else{
			 return "error";
		  }
	}


	function binProc($id) {
		$retval = $this->model->binProc($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreProc($id) {
		$retval = $this->model->restoreProc($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteProc($id) {
		$retval = $this->model->deleteProc($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveProc($id,$startdate,$movedays) {
		$retval = $this->model->moveProc($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getProcFolderDialog($field,$title) {
		$retval = $this->model->getProcFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getProcStatusDialog() {
		global $lang;
		include 'view/dialog_proc_status.php';
	}


	function getAccessDialog() {
		global $lang;
		include 'view/dialog_access.php';
	}
	
	// Notes section
	
	


	// STATISTICS
	function getChartFolder($id,$what) {
		if($chart = $this->model->getChartFolder($id,$what)) {
				include 'view/chart.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}


	function getProcsHelp() {
		global $lang;
		$data["file"] = $lang["PROC_HELP"];
		$data["app"] = "procs";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getProcsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["PROC_FOLDER_HELP"];
		$data["app"] = "procs";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}


	function getBin() {
		global $lang, $procs;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $procs;
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
	  /*if($this->model->isProcOwner($session->uid)) {
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
   
  	function getWidgetAlerts() {
		global $lang, $system;
		if($arr = $this->model->getWidgetAlerts()) {
			$notices = $arr["notices"];
			ob_start();
			include 'view/widget.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["widgetaction"] = $arr["widgetaction"];
			return json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}
	
	
	function markNoticeRead($pid) {
		global $lang, $system;
		$retval = $this->model->markNoticeRead($pid);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	function getNavModulesNumItems($id) {
		$arr = $this->model->getNavModulesNumItems($id);
		return json_encode($arr);
	}

 	function newCheckpoint($id,$date){
		$this->model->newCheckpoint($id,$date);
		return true;
   }

 	function updateCheckpoint($id,$date){
		$this->model->updateCheckpoint($id,$date);
		return true;
   }

 	function deleteCheckpoint($id){
		$this->model->deleteCheckpoint($id);
		return true;
   }
   
   function getCheckpointDetails($app,$module,$id) {
	   global $procs;
	   $retval = $this->model->getCheckpointDetails($app,$module,$id);
	   if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
   }


	function getProcsSearch($term,$exclude) {
		$search = $this->model->getProcsSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedProcs($id) {
		$retval = $this->model->saveLastUsedProcs($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}


   	function getGlobalSearch($term) {
		$search = $this->model->getGlobalSearch($term);
		return $search;
	}


}

$procs = new Procs("procs");
?>