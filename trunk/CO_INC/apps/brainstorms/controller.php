<?php

//include_once("lang/" . $session->userlang . ".php");

class Brainstorms extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new BrainstormsModel();
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
		$data["title"] = $lang["BRAINSTORM_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$brainstorms = $arr["brainstorms"];
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
			$brainstorms = $arr["brainstorms"];
			
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
			$brainstorms = $arr["brainstorms"];
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
			$brainstorms = $arr["brainstorms"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_BRAINSTORM_FOLDER"];
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
			//$this->model->writeActionLog($session->uid,"brainstorms","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$brainstormstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$brainstormstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $brainstormstatus . '", "id": "' . $id . '" }';
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


	function getBrainstormList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getBrainstormList($id,$sort);
		$brainstorms = $arr["brainstorms"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["BRAINSTORM_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getBrainstormDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getBrainstormDetails($id)) {
			$brainstorm = $arr["brainstorm"];
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
		
		if($brainstorm = $this->model->getDates($id)) {
			return json_encode($brainstorm);
		}
	}
	
	
	function printBrainstormMindmap($title,$text,$width,$height) {
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

	function printBrainstormDetails($id, $t) {
		global $session,$date,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getBrainstormPrintDetails($id)) {
			$brainstorm = $arr["brainstorm"];
			$notes = $arr["notes"];
					
					$brainstorm["page_width"] = $brainstorm["css_width"]+245+300;
					$brainstorm["page_height"] = $brainstorm["css_height"]+200;
					if($brainstorm["page_width"] < 896) {
						$brainstorm["page_width"] = 896;
					}
					if($brainstorm["page_height"] < 595) {
						$brainstorm["page_height"] = 595;
					}
					
					ob_start();
					include('view/print.php');
						$html = ob_get_contents();
					ob_end_clean();
					$title = $brainstorm["title"];
					
					
					$this->printBrainstormMindmap($title,$html,$brainstorm["page_width"],$brainstorm["page_height"]);
					
		}
	}

	
	function checkinBrainstorm($id) {
		if($id != "undefined") {
			return $this->model->checkinBrainstorm($id);
		} else {
			return true;
		}
	}

	function getBrainstormSend($id) {
		global $lang;
		if($arr = $this->model->getBrainstormDetails($id)) {
			$brainstorm = $arr["brainstorm"];
			$notes = $arr["notes"];
			
			$form_url = $this->form_url;
			$request = "sendBrainstormDetails";
			$to = "";
			$cc = "";
			$subject = $brainstorm->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendBrainstormDetails($id,$to,$cc,$subject,$body) {
		global $date,$session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getBrainstormPrintDetails($id)) {
			$brainstorm = $arr["brainstorm"];
			$notes = $arr["notes"];
			
			$brainstorm["page_width"] = $brainstorm["css_width"]+245+300;
					$brainstorm["page_height"] = $brainstorm["css_height"]+200;
					if($brainstorm["page_width"] < 896) {
						$brainstorm["page_width"] = 896;
					}
					if($brainstorm["page_height"] < 595) {
						$brainstorm["page_height"] = 595;
					}
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $brainstorm["title"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_BRAINSTORM"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->saveTimeline($title,$html,$attachment,$brainstorm["page_width"],$brainstorm["page_height"]);
		
		// write sento log
		$this->writeSendtoLog("brainstorms",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newBrainstorm($id) {
		$retval = $this->model->newBrainstorm($id);
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function newBrainstormNote($id,$z) {
		$retval = $this->model->newBrainstormNote($id,$z);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	function saveBrainstormNote($id,$title,$text) {
		$retval = $this->model->saveBrainstormNote($id,$title,$text);
		if($retval){
			 $text = stripslashes($text);
			 return nl2br($text);
		  } else{
			 return "error";
		  }
	}
	
	/*function binBrainstormNote($id) {
		$retval = $this->model->binBrainstormNote($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}*/

	function deleteBrainstormNote($id) {
		$retval = $this->model->deleteBrainstormNote($id);
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
	
	
	/*function setBrainstormNoteToggle($id,$t) {
		$retval = $this->model->setBrainstormNoteToggle($id,$t);
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


	function setBrainstormDetails($id,$title,$folder) {
		$retval = $this->model->setBrainstormDetails($id,$title,$folder);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '", "status": "0"}';
		  } else{
			 return "error";
		  }
	}


	function binBrainstorm($id) {
		$retval = $this->model->binBrainstorm($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreBrainstorm($id) {
		$retval = $this->model->restoreBrainstorm($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteBrainstorm($id) {
		$retval = $this->model->deleteBrainstorm($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveBrainstorm($id,$startdate,$movedays) {
		$retval = $this->model->moveBrainstorm($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getBrainstormFolderDialog($field,$title) {
		$retval = $this->model->getBrainstormFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getBrainstormStatusDialog() {
		global $lang;
		include 'view/dialog_brainstorm_status.php';
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


	function getBrainstormsHelp() {
		global $lang;
		$data["file"] = $lang["BRAINSTORM_HELP"];
		$data["app"] = "brainstorms";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getBrainstormsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["BRAINSTORM_FOLDER_HELP"];
		$data["app"] = "brainstorms";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}


	function getBin() {
		global $lang, $brainstorms;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $brainstorms;
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
	  /*if($this->model->isBrainstormOwner($session->uid)) {
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
	   global $brainstorms;
	   $retval = $this->model->getCheckpointDetails($app,$module,$id);
	   if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
   }


}

$brainstorms = new Brainstorms("brainstorms");
?>