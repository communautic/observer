<?php

//include_once("lang/" . $session->userlang . ".php");

class Trainings extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new TrainingsModel();
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
		$data["title"] = $lang["TRAINING_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$trainings = $arr["trainings"];
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
			$trainings = $arr["trainings"];
			ob_start();
			include 'view/folder_edit_list.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}
	
	
	function getFolderDetailsMultiView($id,$view,$zoom) {
		global $date, $lang, $system;
		if($arr = $this->model->getFolderDetailsMultiView($id,$view,$zoom)) {
		$folder = $arr["folder"];
		$trainings = $arr["trainings"];
		ob_start();
			include('view/folder_edit_multiview.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["access"] = $arr["access"];
		return json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}

	function getFolderDetailsStatus($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$trainings = $arr["trainings"];
			ob_start();
			include 'view/folder_edit_status.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			$data["access"] = $arr["access"];
			return json_encode($data);
		} else {
			ob_start();
			include CO_INC .'/view/default.php';
			$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function printFolderDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$trainings = $arr["trainings"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING_FOLDER"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html,1,'logo_print_training.png');
			break;
			default:
				$this->printPDF($title,$html,1,'logo_print_training.png');
		}
		
	}

	function printFolderDetailsList($id) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$trainings = $arr["trainings"];
			ob_start();
				include 'view/folder_print_list.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROJECT_FOLDER"];
		$this->printPDF($title,$html,1,'logo_print_training.png');
	}


	function printFolderDetailsMultiView($id,$view) {
		global $date, $lang, $system;
		if($arr = $this->model->getFolderDetailsMultiView($id,$view)) {
			  $folder = $arr["folder"];
			  $trainings = $arr["trainings"];
			  
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
			  $title = $folder->title . " - " . $lang["PROJECT_TIMELINE_PROJECT_PLAN"];
			  
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
		/*$dompdf->set_paper('a4', 'portrait');  change 'a4' to whatever you want 
         breite, höhe pixel dividiert durch 96 * 72*/
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
			$trainings = $arr["trainings"];
			ob_start();
				include 'view/folder_print_list.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_PROJECT_FOLDER"];
		$this->printPDF($title,$html,1,'logo_print_training.png');
	}


	function getFolderSend($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$trainings = $arr["trainings"];	
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
			$trainings = $arr["trainings"];	
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
			$trainings = $arr["trainings"];	
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
			$trainings = $arr["trainings"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment,1,'logo_print_training.png');
		
		// write sento log
		//$this->writeSendtoLog("trainings",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


function sendFolderDetailsList($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$trainings = $arr["trainings"];
			ob_start();
				include 'view/folder_print_list.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment,1,'logo_print_training.png');
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function sendFolderDetailsMultiView($variable,$id,$to,$cc,$subject,$body) {
		global $session,$users,$date,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getFolderDetailsMultiView($id,$variable)) {
			 $folder = $arr["folder"];
			  $trainings = $arr["trainings"];
			  
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
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->saveTimeline($title,$html,$attachment,$folder->page_width,$folder->page_height);
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"trainings","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$trainingstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$trainingstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $trainingstatus . '", "id": "' . $id . '" }';
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


	function getTrainingList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getTrainingList($id,$sort);
		$trainings = $arr["trainings"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["TRAINING_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getTrainingDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getTrainingDetails($id)) {
			$training = $arr["training"];
			$member = $arr["members"];
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


	function printTrainingDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getTrainingDetails($id)) {
			$training = $arr["training"];
			$member = $arr["members"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $training->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html,1,'logo_print_training.png');
			break;
			default:
				$this->printPDF($title,$html,1,'logo_print_training.png');
		}
		
	}


	function printMemberList($id) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getTrainingDetails($id)) {
			$training = $arr["training"];
			$member = $arr["members"];
			ob_start();
				include 'view/print_memberlist.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $training->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING_MEMBERS"];
		$this->printPDF($title,$html,1,'logo_print_training.png');
		
	}

	function printTrainingHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$trainings = $arr["trainings"];
			ob_start();
				include 'view/handbook_cover.php';
				$html .= ob_get_contents();
			ob_end_clean();
			ob_start();
				include 'view/handbook.php';
				$html .= ob_get_contents();
			ob_end_clean();

			$title = $title = $folder->title . " - " . $lang["TRAINING_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING_MANUAL"];
		$this->printPDF($title,$html,1,'logo_print_training.png');
	}
	
	function checkinTraining($id) {
		if($id != "undefined") {
			return $this->model->checkinTraining($id);
		} else {
			return true;
		}
	}

	function getTrainingSend($id) {
		global $lang;
		if($arr = $this->model->getTrainingDetails($id, 'prepareSendTo')) {
			$training = $arr["training"];
			$form_url = $this->form_url;
			$request = "sendTrainingDetails";
			$to = "";
			$cc = "";
			$subject = $training->title;
			$variable = "";
			$data["error"] = 0;
			$data["error_message"] = "";
			if($training->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $training->sendtoTeamNoEmail;
			}
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function sendTrainingDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getTrainingDetails($id)) {
			$training = $arr["training"];
			$member = $arr["members"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $training->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_TRAINING"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("trainings",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newTraining($id) {
		$retval = $this->model->newTraining($id);
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


	function setTrainingDetails($id,$title,$folder,$management,$management_ct,$company,$team,$team_ct,$training,$training_id_orig,$registration_end,$protocol,$date1,$date2,$date3,$time1,$time2,$time3,$time4,$place1,$place1_ct,$place2,$place2_ct,$text1,$text2,$text3) {
		$retval = $this->model->setTrainingDetails($id,$title,$folder,$management,$management_ct,$company,$team,$team_ct,$training,$registration_end,$protocol,$date1,$date2,$date3,$time1,$time2,$time3,$time4,$place1,$place1_ct,$place2,$place2_ct,$text1,$text2,$text3);
		if($retval){
			 if($training != $training_id_orig) {
			 	return '{ "action": "refresh", "id": "' . $id . '"}';
			 } else {
				 return '{ "action": "edit", "id": "' . $id . '"}';
			 }
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


	function binTraining($id) {
		$retval = $this->model->binTraining($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreTraining($id) {
		$retval = $this->model->restoreTraining($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteTraining($id) {
		$retval = $this->model->deleteTraining($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	
	function restoreMember($id) {
		$retval = $this->model->restoreMember($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteMember($id) {
		$retval = $this->model->deleteMember($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveTraining($id,$startdate,$movedays) {
		$retval = $this->model->moveTraining($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getTrainingFolderDialog($field,$title) {
		$retval = $this->model->getTrainingFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getTrainingStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function getTrainingDialog($field,$title) {
		$retval = $this->model->getTrainingDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	

	function getTrainingMoreDialog($field,$title) {
		$retval = $this->model->getTrainingMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

	function getTrainingCatDialog($field,$title) {
		$retval = $this->model->getTrainingCatDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getTrainingCatMoreDialog($field,$title) {
		$retval = $this->model->getTrainingCatMoreDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
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
	
	
	function getTrainingsHelp() {
		global $lang;
		$data["file"] = $lang["TRAINING_HELP"];
		$data["app"] = "trainings";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getTrainingsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["TRAINING_FOLDER_HELP"];
		$data["app"] = "trainings";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $trainings;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $trainings;
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
	  /*if($this->model->isTrainingOwner($session->uid)) {
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
			$kickoffs = $arr["kickoffs"];
			$starts = $arr["starts"];
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

	function getNavModulesNumItems($id) {
		$arr = $this->model->getNavModulesNumItems($id);
		return json_encode($arr);
	}
	
	/*function getTrainingTitle($id){
		$title = $this->model->getTrainingTitle($id);
		return $title;
   }*/
   
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
	   global $projects;
	   $retval = $this->model->getCheckpointDetails($app,$module,$id);
	   if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
   }   

	function updateCheckpointText($id,$text){
		$this->model->updateCheckpointText($id,$text);
		return true;
   }


	function getTrainingsSearch($term,$exclude) {
		$search = $this->model->getTrainingsSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedTrainings($id) {
		$retval = $this->model->saveLastUsedTrainings($id);
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
	
	function addMember($pid,$id) {
		global $lang;
		$arr = $this->model->addMember($pid,$id);
		$value = $arr["members"];
		$training->canedit = true;
		$data["status"] = $arr["status"];
		$data["error"] = $arr["error"];
		$data["error_data"] = $arr["error_data"];
		if($data["status"]) {
		ob_start();
			include('view/member.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		} else {
			$data["html"] = '';
		}
		
		return json_encode($data);
	}
	
function getGroupIDs($id) {
		$arr = $this->model->getGroupIDs($id);
		return $arr;
	}
   
   function sendInvitation($id) {
		global $lang, $session, $contactsmodel,$date;
		$key = uniqid(md5(rand()));
		$this->model->storeKey($id,$key,'invitation');
		$member = $this->model->getMemberDetails($id);
		$arr = $this->model->getTrainingDetails($member->pid);
		$training = $arr["training"];
		$to = $member->cid;
		$from = CO_TRAININGS_COMPANY_EMAIL;
		$fromName = CO_TRAININGS_COMPANY_NAME;
		$subject = 'Einladung zur Trainingsveranstaltung "' . $training->title . '"';
		$email_header = str_replace('https','http',CO_PATH_URL . "/data/templates/trainings/recheis_akademie.jpg");
		$email_button_accept = str_replace('https','http',CO_FILES . "/img/" . $lang["TRAINING_BUTTON_ACCEPT"]);
		$email_button_decline = str_replace('https','http',CO_FILES . "/img/" . $lang["TRAINING_BUTTON_DECLINE"]);
		$email_accept_url = CO_PATH_URL . '/?path=api/apps/trainings&request=accept&key=' . $key;
		$email_decline_url = CO_PATH_URL . '/?path=api/apps/trainings&request=decline&key=' . $key;
		ob_start();
			include('view/email_training_cat'.$training->training_id.'.php');
			$cat = ob_get_contents();
		ob_end_clean();

		ob_start();
			include('view/email_invitation.php');
			$body = ob_get_contents();
		ob_end_clean();
		
		/*ob_start();
			include(CO_PATH_TEMPLATES . 'trainings/email_footer.html');
			$body .= ob_get_contents();
		ob_end_clean();*/
		
		$email = $this->sendEmail($to,$cc="",$from,$fromName,$subject,$body,"","","",0,0);
		$this->model->writeMemberLog($id,'1',$session->uid);
		
		$data['action'] = $lang['TRAINING_MEMBER_LOG_1'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function manualInvitation($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->manualInvitation($id);
		$this->model->writeMemberLog($id,'0',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_0'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function resetInvitation($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->resetInvitation($id);
		$this->model->writeMemberLog($id,'8',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_8'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function acceptInvitation($id,$who) {
		global $lang, $session, $contactsmodel,$date;
		$retval = $this->model->acceptInvitation($id);
		if($retval){
			$member = $this->model->getMemberDetails($id);
			$arr = $this->model->getTrainingDetails($member->pid);
			$training = $arr["training"];
			$to = $member->cid;
			$from = CO_TRAININGS_COMPANY_EMAIL;
			$fromName = CO_TRAININGS_COMPANY_NAME;
			$subject = 'Anmeldung zur Trainingsveranstaltung "' . $training->title . '"';
			$response = $lang['TRAINING_INVITATION_RESPONSE_ACCEPT2'];
			$email_header = str_replace('https','http',CO_PATH_URL . "/data/templates/trainings/recheis_akademie.jpg");
			ob_start();
				include('view/email_training_cat'.$training->training_id.'.php');
				$cat = ob_get_contents();
			ob_end_clean();
			ob_start();
				include('view/email_invitation_response.php');
				$body = ob_get_contents();
			ob_end_clean();
			$email = $this->sendEmail($to,$cc="",$from,$fromName,$subject,$body,"","","",0,0);
			$this->model->writeMemberLog($id,'2',$who);
			 echo true;
		  } else{
			 echo false;
		  }
	}
	
	function declineInvitation($id,$who) {
		global $lang, $session, $contactsmodel,$date;
		$retval = $this->model->declineInvitation($id);
		if($retval){
			$member = $this->model->getMemberDetails($id);
			$arr = $this->model->getTrainingDetails($member->pid);
			$training = $arr["training"];
			$to = $member->cid;
			$from = CO_TRAININGS_COMPANY_EMAIL;
			$fromName = CO_TRAININGS_COMPANY_NAME;
			$subject = 'Abmeldung zur Trainingsveranstaltung "' . $training->title . '"';
			$response = $lang['TRAINING_INVITATION_RESPONSE_DECLINE2'];
			$email_header = str_replace('https','http',CO_PATH_URL . "/data/templates/trainings/recheis_akademie.jpg");
			ob_start();
				include('view/email_training_cat'.$training->training_id.'.php');
				$cat = ob_get_contents();
			ob_end_clean();
			ob_start();
				include('view/email_invitation_response.php');
				$body = ob_get_contents();
			ob_end_clean();
			$email = $this->sendEmail($to,$cc="",$from,$fromName,$subject,$body,"","","",0,0);
			$this->model->writeMemberLog($id,'4',$who);
			 echo true;
		  } else{
			 echo false;
		  }
	}
	
	function manualRegistration($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->manualRegistration($id);
		$this->model->writeMemberLog($id,'3',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_3'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function removeRegistration($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->removeRegistration($id);
		$this->model->writeMemberLog($id,'4',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_4'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function resetRegistration($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->resetRegistration($id);
		$this->model->writeMemberLog($id,'9',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_9'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}

	function manualTookpart($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->manualTookpart($id);
		$this->model->writeMemberLog($id,'5',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_5'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function manualTookNotpart($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->manualTookNotpart($id);
		$this->model->writeMemberLog($id,'12',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_12'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function resetTookpart($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->resetTookpart($id);
		$this->model->writeMemberLog($id,'6',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_6'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function editFeedback($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->editFeedback($id);
		$this->model->writeMemberLog($id,'7',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_7'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function resetFeedback($id) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->resetFeedback($id);
		$this->model->writeMemberLog($id,'10',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_10'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}

	function prepareTrainingdata($id) {
		global $lang;
		$member = $this->model->getMemberDetails($id);
		$arr = $this->model->getTrainingDetails($member->pid);
		$training = $arr["training"];
		return $training;
	}
	
	


   function sendFeedback($id) {
		global $lang, $session, $contactsmodel,$date;
		$key = uniqid(md5(rand()));
		$this->model->storeKey($id,$key,'feedback');
		$member = $this->model->getMemberDetails($id);
		$arr = $this->model->getTrainingDetails($member->pid);
		$training = $arr["training"];
		$to = $member->cid;
		$from = CO_TRAININGS_COMPANY_EMAIL;
		$fromName = CO_TRAININGS_COMPANY_NAME;
		$subject = 'Feedback zur Trainingsveranstaltung "' . $training->title . '"';
		$email_header = str_replace('https','http',CO_PATH_URL . "/data/templates/trainings/recheis_akademie.jpg");
		$email_button_feedback = str_replace('https','http',CO_FILES . "/img/" . $lang["TRAINING_BUTTON_FEEDBACK"]);
		$email_feedback_url = CO_PATH_URL . '/?path=api/apps/trainings&request=feedback&key=' . $key;
		ob_start();
			include('view/email_training_cat'.$training->training_id.'.php');
			$cat = ob_get_contents();
		ob_end_clean();
		
		ob_start();
			include('view/email_feedback.php');
			$body = ob_get_contents();
		ob_end_clean();
		
		$email = $this->sendEmail($to,$cc="",$from,$fromName,$subject,$body,"","","",0,0);
		$this->model->writeMemberLog($id,'7',$session->uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_7'];
		$data['who'] = $contactsmodel->getUserListPlain($session->uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
	
	function saveFeedback($id,$uid,$q1,$q2,$q3,$q4,$q5,$feedback_text) {
		global $lang, $session, $contactsmodel,$date;
		$this->model->saveFeedback($id,$uid,$q1,$q2,$q3,$q4,$q5,$feedback_text);
		$this->model->writeMemberLog($id,'11',$uid);
		$data['action'] = $lang['TRAINING_MEMBER_LOG_11'];
		$data['who'] = $contactsmodel->getUserListPlain($uid);
		$data['date'] = $date->formatDate(gmdate("Y-m-d H:i:s"),CO_DATETIME_FORMAT);
		return json_encode($data);
	}
   
   function binMember($id) {
		$retval = $this->model->binMember($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
   
   
}

$trainings = new Trainings("trainings");
?>