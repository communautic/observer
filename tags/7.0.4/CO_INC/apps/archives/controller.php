<?php

//include_once("lang/" . $session->userlang . ".php");

class Archives extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ArchivesModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			$this->archiveDisplay = false;
			$this->contactsDisplay = false; // list access status on contact page
			
			/*if (!$session->isSysadmin()) {
				$this->canView = $this->model->getViewPerms($session->uid);
				$this->canEdit = $this->model->getEditPerms($session->uid);
				$this->canAccess = array_merge($this->canView,$this->canEdit);
			}*/
	}
	
	function archivesMeta($module,$id) {
		global $lang;
		include 'view/dialog_meta.php';
	}
	
	
	function getArchivesHelp() {
		global $lang;
		$data["file"] = $lang["ARCHIVE_HELP"];
		//$data["app"] = "archives";
		//$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getArchivesFoldersHelp() {
		global $lang;
		//$data["file"] =  $lang["ARCHIVE_FOLDER_HELP"];
		$data["file"] = $lang["ARCHIVE_HELP"];
		$data["app"] = "archives";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getBin() {
		global $lang, $archives;
		foreach($this->applications as $app => $display) {
				return ${$app.'_name'};
				if(${$app}->archiveDisplay) {
					//if($session->isSysadmin()) {
					return('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>'); 
					/*} else {
						if(!empty(${$app}->canAccess)) {
							echo('<li id="folderItem_"><span rel="' . $app . '" class="module-click"><span class="text">' . ${$app.'_name'} . '</span></span></li>'); 
				}
					}*/
				}
			}
		
		
		/*if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}*/
	}

	/*function getFolderDetails($id) {
		global $lang, $system;
		
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];
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
	

	function getFolderDetailsList($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];
			ob_start();
			include 'view/folder_edit_list.php';
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
	
	
	function getFolderDetailsMultiView($id,$view,$zoom) {
		global $date, $lang, $system;
		if($arr = $this->model->getFolderDetailsMultiView($id,$view,$zoom)) {
		$folder = $arr["folder"];
		$archives = $arr["archives"];
		ob_start();
			include('view/folder_edit_multiview.php');
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

	function getFolderDetailsStatus($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];
			ob_start();
			include 'view/folder_edit_status.php';
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
			$archives = $arr["archives"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE_FOLDER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	
	function printFolderDetailsList($id) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];
			ob_start();
				include 'view/folder_print_list.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE_FOLDER"];
		$this->printPDF($title,$html);
	}


	function printFolderDetailsMultiView($id,$view) {
		global $date, $lang, $system;
		if($arr = $this->model->getFolderDetailsMultiView($id,$view)) {
			  $folder = $arr["folder"];
			  $archives = $arr["archives"];
			  
			  $folder->page_width = $folder->css_width+245+20;
			  $folder->page_height = $folder->css_height+200;
			  if($folder->page_width < 896) {
				  $folder->page_width = 896;
			  }
			  if($folder->page_height < 595) {
				  $folder->page_height = 595;
			  }
			  
			  ob_start();
			  include('view/folder_print_multiview.php');
				  $html = ob_get_contents();
			  ob_end_clean();
			  $title = $folder->title . " - " . $lang["ARCHIVE_TIMELINE_ARCHIVE_PLAN"];
			  
			  $this->printGantt($title,$html,$folder->page_width,$folder->page_height);
		}
	}
	
	
	function printGantt($title,$text,$width,$height) {
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
        $dompdf->set_paper( array(0,0, $width / 96 * 72, $height / 96 * 72), "portrait" );
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
	}

	function printFolderDetailsStatus($id) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];
			ob_start();
				include 'view/folder_print_list.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE_FOLDER"];
		$this->printPDF($title,$html);
	}


	function getFolderSend($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];	
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


	function getSendFolderDetailsList($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];	
			$form_url = $this->form_url;
			$request = "sendFolderDetailsList";
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


	function getSendFolderDetailsMultiView($id,$view) {
		global $lang;
		if($arr = $this->model->getFolderDetailsMultiview($id,$view)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];	
			$form_url = $this->form_url;
			$request = "sendFolderDetailsMultiView";
			$to = "";
			$cc = "";
			$subject = $folder->title;
			$variable = $view;
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
			$archives = $arr["archives"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("archives",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	
	function sendFolderDetailsList($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$archives = $arr["archives"];
			ob_start();
				include 'view/folder_print_list.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function sendFolderDetailsMultiView($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users,$date,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetailsMultiView($id,$variable)) {
			 $folder = $arr["folder"];
			  $archives = $arr["archives"];
			  
			  $folder->page_width = $folder->css_width+245+20;
			  $folder->page_height = $folder->css_height+200;
			  if($folder->page_width < 896) {
				  $folder->page_width = 896;
			  }
			  if($folder->page_height < 595) {
				  $folder->page_height = 595;
			  }
			ob_start();
				include 'view/folder_print_multiview.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->saveTimeline($title,$html,$attachment,$folder->page_width,$folder->page_height);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"archives","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$archivestatus) {
		$retval = $this->model->setFolderDetails($id,$title,$archivestatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $archivestatus . '", "id": "' . $id . '" }';
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


	function getArchiveList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getArchiveList($id,$sort);
		$archives = $arr["archives"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["ARCHIVE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getArchiveDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getArchiveDetails($id)) {
			$archive = $arr["archive"];
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
		
		if($archive = $this->model->getDates($id)) {
			return json_encode($archive);
		}
	}


	function printArchiveDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getArchiveDetails($id)) {
			$archive = $arr["archive"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $archive->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printArchiveHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getArchiveDetails($id)) {
			$archive = $arr["archive"];
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
			$phasescont = new ArchivesPhases("phases");
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
			$archivesDocuments = new ArchivesDocuments("documents");
			if($arrdocs = $archivesDocuments->model->getList($id,"0")) {
				$docs = $arrdocs["documents"];
				foreach ($docs as $doc) {
					if($arr = $archivesDocuments->model->getDetails($doc->id)) {
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
			$archivesControlling = new ArchivesControlling("controlling");
			if($cont = $archivesControlling->model->getDetails($id)) {
				$tit = $archive->title;
				ob_start();
					include 'modules/controlling/view/print.php';
					$html .= ob_get_contents();
				ob_end_clean();
			}
			$title = $archive->title . " - " . $lang["ARCHIVE_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinArchive($id) {
		if($id != "undefined") {
			return $this->model->checkinArchive($id);
		} else {
			return true;
		}
	}

	function getArchiveSend($id) {
		global $lang;
		if($arr = $this->model->getArchiveDetails($id, 'prepareSendTo')) {
			$archive = $arr["archive"];
			$phases = $arr["phases"];
			$num = $arr["num"];

			$form_url = $this->form_url;
			$request = "sendArchiveDetails";
			$to = $archive->sendtoTeam;
			$cc = "";
			$subject = $archive->title;
			$variable = "";
			$data["error"] = 0;
			$data["error_message"] = "";
			if($archive->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $archive->sendtoTeamNoEmail;
			}
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function sendArchiveDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getArchiveDetails($id)) {
			$archive = $arr["archive"];
			$phases = $arr["phases"];
			$num = $arr["num"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $archive->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_ARCHIVE"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("archives",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newArchive($id) {
		$retval = $this->model->newArchive($id);
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


	function setArchiveDetails($id,$title,$startdate,$startdate_orig,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder) {
		$retval = $this->model->setArchiveDetails($id,$title,$startdate,$startdate_orig,$ordered_by,$ordered_by_ct,$management,$management_ct,$team,$team_ct,$protocol,$folder);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '"}';
		  } else{
			 return "error";
		  }
	}
	
	function updateStatus($id,$date,$status) {
		$retval = $this->model->updateStatus($id,$date,$status);
		if($retval){
			 return '{ "id": "' . $id . '", "status": "' . $status . '"}';
		 }
	}


	function binArchive($id) {
		$retval = $this->model->binArchive($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreArchive($id) {
		$retval = $this->model->restoreArchive($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteArchive($id) {
		$retval = $this->model->deleteArchive($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveArchive($id,$startdate,$movedays) {
		$retval = $this->model->moveArchive($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getArchiveFolderDialog($field,$title) {
		$retval = $this->model->getArchiveFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getArchiveStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
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
	
	
	

	function getBin() {
		global $lang, $archives;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $archives;
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
			$reminders = $arr["reminders"];
			$kickoffs = $arr["kickoffs"];
			$alerts = $arr["alerts"];
			$notices = $arr["notices"];
			$archivelinks = $arr["archivelinks"];
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

	function markNoticeDelete($id) {
		global $lang, $system;
		$retval = $this->model->markNoticeDelete($id);
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
	   global $archives;
	   $retval = $this->model->getCheckpointDetails($app,$module,$id);
	   if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
   }


	function getArchivesSearch($term,$exclude) {
		$search = $this->model->getArchivesSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedArchives($id) {
		$retval = $this->model->saveLastUsedArchives($id);
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
	
	function toggleCosts($id,$status) {
		$retval = $this->model->toggleCosts($id,$status);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	function toggleCurrency($id,$cur) {
		$retval = $this->model->toggleCurrency($id,$cur);
		if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}*/

}

$archives = new Archives("archives");
?>