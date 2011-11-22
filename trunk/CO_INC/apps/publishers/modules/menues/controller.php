<?php

class PublishersMenues extends Publishers {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/publishers/modules/$name/";
			$this->model = new PublishersMenuesModel();
			$this->binDisplay = true;
	}


	function getList($sort) {
		global $system, $lang;
		$arr = $this->model->getList($sort);
		$menues = $arr["menues"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["PUBLISHER_MENUE_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$menue = $arr["menue"];
			$sendto = $arr["sendto"];
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
		global $session, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$menue = $arr["menue"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $menue->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PUBLISHER_PRINT_MENUE"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	function printMenue($id) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$menue = $arr["menue"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print_external.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $menue->title;
		}
		//$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PUBLISHER_PRINT_MENUE"];
		//$this->printPDF($title,$html);
		
		ob_start();
			include("view/printheader.php");
			$header = ob_get_contents();
		ob_end_clean();
		
		$pdfheader = CO_PATH_BASE . "/data/templates/menueheader.php";
		if(file_exists($pdfheader)) {
			ob_start();
				include_once($pdfheader);
				$headerpdf = ob_get_contents();
			ob_end_clean();
		} else {
			$headerpdf = "";
		}
		$footer = "</body></html>";
        $html = $header . '<script type="text/php">' . $headerpdf  . '</script>' . $html . $footer;
		require_once(CO_INC . "/classes/dompdf_60_beta2/dompdf_config.inc.php");
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'landscape');
		$dompdf->render();
		$options['Attachment'] = 1;
		$options['Accept-Ranges'] = 0;
		$options['compress'] = 1;
		$dompdf->stream($title.".pdf", $options);
		
		
		/*$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('a4', 'landscape'); // change 'a4' to whatever you want
		$dompdf->render();
		$pdf = $dompdf->output();
		file_put_contents( CO_PATH_BASE . "/data/menues/kinder.pdf", $pdf);*/
	}
	
	
	function getSend($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$menue = $arr["menue"];			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $menue->management;
			$cc = "";
			$subject = $menue->title;
			$variable = "";
			
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session, $users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$menue = $arr["menue"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $menue->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PUBLISHER_PRINT_MENUE"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("publishers_menues",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function checkinMenue($id) {
		if($id != "undefined") {
			return $this->model->checkinMenue($id);
		} else {
			return true;
		}
	}
	

	function setDetails($id,$title,$date_from,$date_to,$protocol,$management,$management_ct,$menue_access,$menue_access_orig,$menue_status,$menue_status_date) {
		if($arr = $this->model->setDetails($id,$title,$date_from,$date_to,$protocol,$management,$management_ct,$menue_access,$menue_access_orig,$menue_status,$menue_status_date)){
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $menue_access . '", "status": "' . $menue_status . '"}';
		} else{
			return "error";
		}
	}


	function createNew() {
		$retval = $this->model->createNew();
		if($retval){
			 return '{ "what": "menue" , "action": "new", "id": "' . $retval . '" }';
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


	function binMenue($id) {
		$retval = $this->model->binMenue($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreMenue($id) {
		$retval = $this->model->restoreMenue($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteMenue($id) {
		$retval = $this->model->deleteMenue($id);
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

	
	function getMenueStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}
	
	function saveItem($id,$what,$text) {
		$retval = $this->model->saveItem($id,$what,$text);
		if($retval){
			 return nl2br(stripslashes($text));
		  } else{
			 return "error";
		  }
	}


	function archiveOthers($id) {
		$retval = $this->model->archiveOthers($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }	
	}


	function getMenuesDialog($field) {
		$retval = $this->model->getMenuesDialog($field);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }	
	}
	
	

	function getHelp() {
		global $lang;
		$data["file"] =  $lang["PUBLISHER_MENUE_HELP"];
		$data["app"] = "publishers";
		$data["module"] = "/modules/menues";
		$this->openHelpPDF($data);
	}
	
}

$publishersMenues = new PublishersMenues("menues");
?>