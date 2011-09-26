<?php

class BrainstormsRosters extends Brainstorms {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/brainstorms/modules/$name/";
			$this->model = new BrainstormsRostersModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system,$lang;
		$arr = $this->model->getList($id,$sort);
		$rosters = $arr["rosters"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["BRAINSTORM_ROSTER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$roster = $arr["roster"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$projects = $arr["projects"];
			ob_start();
				include 'view/edit.php';
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


	function printDetails($id,$t) {
		global $session,$date,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getDetails($id)) {
			$roster = $arr["roster"];
			$cols = $arr["cols"];
			ob_start();
					include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $roster->title . " - " . $lang["BRAINSTORM_ROSTER_TITLE"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROJECT_PRINT_TIMELINE"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		/*if($arr = $this->model->getDetails($id)) {
			$roster = $arr["roster"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$projects = $arr["projects"];
			
			$page_width = sizeof($cols)*150+245+300;
					$page_height = $colheight+200;
					if($page_width < 896) {
						$page_width = 896;
					}
					if($page_height < 595) {
						$page_height = 595;
					}
			
			
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $roster->title;
					
					
			$this->printBrainstormRoster($title,$html,$page_width,$page_height);
		}*/
	}
	
	function printBrainstormRoster($title,$text,$width,$height) {
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
	
	function getSend($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$roster = $arr["roster"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$projects = $arr["projects"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $roster->title;
			$variable = "";
			
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session, $date, $users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$roster = $arr["roster"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$projects = $arr["projects"];
			
			$page_width = sizeof($cols)*150+245+300;
					$page_height = $colheight+200;
					if($page_width < 896) {
						$page_width = 896;
					}
					if($page_height < 595) {
						$page_height = 595;
					}
					
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $roster->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["BRAINSTORM_PRINT_ROSTER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->saveTimeline($title,$html,$attachment,$page_width,$page_height);
		
		// write sento log
		$this->writeSendtoLog("brainstorms_rosters",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinRoster($id) {
		if($id != "undefined") {
			return $this->model->checkinRoster($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$roster_access,$roster_access_orig) {
		if($arr = $this->model->setDetails($pid,$id,$title,$roster_access,$roster_access_orig)){
			if($arr["what"] == "edit") {
				//return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $roster_access . '", "status": "' . $roster_status . '"}';
				return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $roster_access . '"}';
			} else {
				return '{ "action": "reload" , "id": "' . $arr["id"] . '", "access": "' . $roster_access . '"}';
			}
		} else{
			return "error";
		}
	}


	function saveRosterColumns($cols) {
			$retval = $this->model->saveRosterColumns($cols);
			if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	function newRosterColumn($id,$sort) {
			$retval = $this->model->newRosterColumn($id,$sort);
			if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function binRosterColumn($id) {
			$retval = $this->model->binRosterColumn($id);
			if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function saveRosterItems($col,$items) {
			$retval = $this->model->saveRosterItems($col,$items);
			if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	function getRosterNote($id) {
		global $lang;
		if($note = $this->model->getRosterNote($id)){
			//ob_start();
			//include('view/note.php');
			//$data["html"] = ob_get_contents();
		//ob_end_clean();
			$data["title"] = $note->title;
			$data["text"] = $note->text;
			$data["info"] = $lang["EDITED_BY_ON"] . ' ' . $note->edited_user.', ' . $note->edited_date . '<br>'
. $lang["CREATED_BY_ON"]  . ' ' . $note->created_user . ', ' . $note->created_date;
            $data["ms"] = $note->ms;
			return json_encode($data);
		} else{
			return "error";
		}
	}	
	
	function saveRosterNewNote($pid,$id) {
			$retval = $this->model->saveRosterNewNote($pid,$id);
			if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}	
	
	function saveRosterNewManualNote($pid) {
			global $lang;
			$retval = $this->model->saveRosterNewManualNote($pid);
			if($retval){
				$html = '<div id="item_' . $retval . '"><span>' . $lang["BRAINSTORM_ROSTER_ITEM_NEW"] . '</span><div class="binItem-Outer"><a class="binItem" rel="'.$retval.'"><span class="icon-delete"></span></a></div></div>';
			 return $html;
		  } else{
			 return "error";
		  }
	}

	function saveRosterNote($id,$title,$text) {
		$retval = $this->model->saveRosterNote($id,$title,$text);
		if($retval){
			 return $title;
		  } else{
			 return "error";
		  }
	}
	
	function toggleMilestone($id,$ms) {
		$retval = $this->model->toggleMilestone($id,$ms);
		if($retval){
			 return true;
		  } else{
			 return "error";
		  }
	}

	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "roster" , "action": "new", "id": "' . $retval . '" }';
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


	function binRoster($id) {
		$retval = $this->model->binRoster($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreRoster($id) {
		$retval = $this->model->restoreRoster($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteRoster($id) {
		$retval = $this->model->deleteRoster($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function restoreRosterColumn($id) {
		$retval = $this->model->restoreRosterColumn($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteRosterColumn($id) {
		$retval = $this->model->deleteRosterColumn($id);
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


	function addTask($mid,$num,$sort) {
		$task = $this->model->addTask($mid,$num,$sort);
		$roster->canedit = 1;
		foreach($task as $value) {
			$checked = '';
			if($value->status == 1) {
				$checked = ' checked="checked"';
			}
			include 'view/task.php';
		}
	}


	function deleteTask($id) {
		$retval = $this->model->deleteTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function restoreRosterTask($id) {
		$retval = $this->model->restoreRosterTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deleteRosterTask($id) {
		$retval = $this->model->deleteRosterTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	
		function binItem($id) {
		$retval = $this->model->binItem($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function getRosterStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	
	function convertToProject($id,$kickoff,$folder,$protocol) {
		if($data = $this->model->convertToProject($id,$kickoff,$folder,$protocol)){
			return json_encode($data);
		} else{
			return "error";
		}
	}


	function getHelp() {
		global $lang;
		$data["file"] =  $lang["BRAINSTORM_ROSTER_HELP"];
		$data["app"] = "brainstorms";
		$data["module"] = "/modules/rosters";
		$this->openHelpPDF($data);
	}

}

$brainstormsRosters = new BrainstormsRosters("rosters");
?>