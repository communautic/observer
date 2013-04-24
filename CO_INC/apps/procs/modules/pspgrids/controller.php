<?php

class ProcsPspgrids extends Procs {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/procs/modules/$name/";
			$this->model = new ProcsPspgridsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$pspgrids = $arr["pspgrids"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PROC_PSPGRID_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$pspgrid = $arr["pspgrid"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$listheight = $arr["listheight"];
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
			$pspgrid = $arr["pspgrid"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$listheight = $arr["listheight"];
			$projects = $arr["projects"];
			
			$page_width = sizeof($cols)*203+100+100;
			$page_height = $pspgrid->max_items*20+5+20+142+100+100;
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
			$title = $pspgrid->title;
					
					
			$this->printPspgrid($title,$html,$page_width,$page_height);
		}
	}
	
	function printPspgrid($title,$text,$width,$height) {
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
			$pspgrid = $arr["pspgrid"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$projects = $arr["projects"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $pspgrid->title;
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
			$pspgrid = $arr["pspgrid"];
			$cols = $arr["cols"];
			$console_items = $arr["console_items"];
			$sendto = $arr["sendto"];
			$colheight = $arr["colheight"];
			$listheight = $arr["listheight"];
			$projects = $arr["projects"];
			
			$page_width = sizeof($cols)*203+100+100;
			$page_height = $pspgrid->max_items*20+5+20+142+100+100;
			if($page_width < 896) {
				$page_width = 896;
			}
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $pspgrid->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PROC_PRINT_PSPGRID"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->saveTimeline($title,$html,$attachment,$page_width,$page_height);
		
		// write sento log
		$this->writeSendtoLog("procs_pspgrids",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function checkinPspgrid($id) {
		if($id != "undefined") {
			return $this->model->checkinPspgrid($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$owner,$owner_ct,$management,$management_ct,$team,$team_ct,$pspgrid_access,$pspgrid_access_orig) {
		if($arr = $this->model->setDetails($pid,$id,$title,$owner,$owner_ct,$management,$management_ct,$team,$team_ct,$pspgrid_access,$pspgrid_access_orig)){
			if($arr["what"] == "edit") {
				//return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $pspgrid_access . '", "status": "' . $pspgrid_status . '"}';
				return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $pspgrid_access . '"}';
			} else {
				return '{ "action": "reload" , "id": "' . $arr["id"] . '", "access": "' . $pspgrid_access . '"}';
			}
		} else{
			return "error";
		}
	}


	function savePspgridColumns($cols) {
			$retval = $this->model->savePspgridColumns($cols);
			if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	function savePspgridColDays($id,$days) {
			$retval = $this->model->savePspgridColDays($id,$days);
			if($retval){
			 return 'true';
		  } else{
			 return "error";
		  }
	}
	
	function newPspgridColumn($id,$sort) {
			$retval = $this->model->newPspgridColumn($id,$sort);
			if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function binPspgridColumn($id) {
			$retval = $this->model->binPspgridColumn($id);
			if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function savePspgridItems($col,$items) {
			if($items != "") {
				$retval = $this->model->savePspgridItems($col,$items);
				if($retval){
					 return 'true';
				  } else{
					 return "error";
				  }
			} else {
				return 'true';
			}
	}
	
	function getPspgridNote($id) {
		global $lang;
		if($note = $this->model->getPspgridNote($id)){
			$data["title"] = $note->title;
			$data["text"] = $note->text;
			$data["info"] = $lang["EDITED_BY_ON"] . ' ' . $note->edited_user.', ' . $note->edited_date . '<br>'
. $lang["CREATED_BY_ON"]  . ' ' . $note->created_user . ', ' . $note->created_date;
			return json_encode($data);
		} else{
			return "error";
		}
	}	
	
	function savePspgridNewNote($pid,$id) {
			$retval = $this->model->savePspgridNewNote($pid,$id);
			if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}	
	
	function savePspgridNewNoteTitle($pid,$id,$col) {
			$retval = $this->model->savePspgridNewNoteTitle($pid,$id,$col);
			if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function savePspgridNoteTitle($id,$col) {
			$retval = $this->model->savePspgridNoteTitle($id,$col);
			if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function savePspgridNewManualNote($pid) {
			global $lang;
			$retval = $this->model->savePspgridNewManualNote($pid);
			if($retval){
				$html = '<div request="note" class="droppable showCoPopup planned" rel="' . $retval . '" id="procspspgriditem_' . $retval . '" style="display: none;"><div class="itemTitle">' . $lang["PROC_PSPGRID_ITEM_NEW"] . '</div><div class="light"><div class="itemMilestone">0</div><div class="itemText"></div><div class="itemTeamprint"></div><div class="colTotals"><span class="totaldays">0</span> <span>Tag/e</span> - <span>' . CO_DEFAULT_CURRENCY . '</span> <span class="totalcosts">0</span></div><div class="itemTeam"></div><div class="itemCostsEmployees costs">0</div><div class="itemCostsMaterials costs">0</div><div class="itemCostsExternal costs">0</div><div class="itemCostsOther costs">0</div><div class="itemDays"><span class="days">0</span> Tag/e</div><div class="itemTeamct"><a field="itemTeamct coPopup-team_ct" class="ct-content"></a></div><div class="itemStatus">0</div></div></div>';
			 return $html;
		  } else{
			 return "error";
		  }
	}
	
	function savePspgridNewManualTitle($pid,$col) {
			global $lang;
			$retval = $this->model->savePspgridNewManualTitle($pid,$col);
			if($retval){
				$html = '<div request="title" class="droppable showCoPopup colTitle planned" rel="' . $retval . '" id="procspspgriditem_' . $retval . '"><div class="itemTitle">' . $lang["PROC_PSPGRID_TITLE_NEW"] . '</div><div class="light"><div class="itemMilestone milestone">0</div><div class="itemText"></div><div class="itemTeamprint"></div><div class="colTotals"><span class="totaldays"> 0</span> <span>Tag/e</span> - <span>' . CO_DEFAULT_CURRENCY . '</span> <span class="totalcosts">0</span></div><div class="itemTeam"></div><div class="itemCostsEmployees costs">0</div><div class="itemCostsMaterials costs">0</div><div class="itemCostsExternal costs">0</div><div class="itemCostsOther costs">0</div><div class="itemDays"><span class="days">10</span> ' . $lang['PROC_PSPGRID_DAYS'] . '</div><div class="itemTeamct"><a field="coPopup-team_ct" class="ct-content"></a></div><div class="itemStatus">0</div></div></div>';
			 return $html;
		  } else{
			 return "error";
		  }
	}

	
	function setItemStatus($id,$status) {
		$retval = $this->model->setItemStatus($id,$status);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function setItemType($id,$type) {
		$retval = $this->model->setItemType($id,$type);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}

	function savePspgridNote($id,$title,$team,$team_ct,$text,$days,$costs_employees,$costs_materials,$costs_external,$costs_other) {
		$retval = $this->model->savePspgridNote($id,$title,$team,$team_ct,$text,$days,$costs_employees,$costs_materials,$costs_external,$costs_other);
		if($retval){
			 return $title;
		  } else{
			 return "error";
		  }
	}
	
	/*function toggleMilestone($id,$ms) {
		$retval = $this->model->toggleMilestone($id,$ms);
		if($retval){
			 return true;
		  } else{
			 return "error";
		  }
	}*/

	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "pspgrid" , "action": "new", "id": "' . $retval . '" }';
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


	function binPspgrid($id) {
		$retval = $this->model->binPspgrid($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restorePspgrid($id) {
		$retval = $this->model->restorePspgrid($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deletePspgrid($id) {
		$retval = $this->model->deletePspgrid($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function restorePspgridColumn($id) {
		$retval = $this->model->restorePspgridColumn($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deletePspgridColumn($id) {
		$retval = $this->model->deletePspgridColumn($id);
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
		$pspgrid->canedit = 1;
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
	
	function restorePspgridTask($id) {
		$retval = $this->model->restorePspgridTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}
	
	function deletePspgridTask($id) {
		$retval = $this->model->deletePspgridTask($id);
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
	
	function getPspgridStatusDialog() {
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

	function getCoPopup() {
		global $system, $lang;
		ob_start();
			include('view/copopup.php');
			$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PROC_PSPGRID_HELP"];
		$data["app"] = "procs";
		$data["module"] = "/modules/pspgrids";
		$this->openHelpPDF($data);
	}

}

$procsPspgrids = new ProcsPspgrids("pspgrids");
?>