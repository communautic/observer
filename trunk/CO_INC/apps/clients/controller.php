<?php

//include_once("lang/" . $session->userlang . ".php");

class Clients extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ClientsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			$this->archiveDisplay = false;
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
		$data["title"] = $lang["CLIENT_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$clients = $arr["clients"];
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
			$clients = $arr["clients"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_CLIENT_FOLDER"];
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
			$clients = $arr["clients"];	
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
			$clients = $arr["clients"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_CLIENT_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("clients",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"clients","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$clientstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$clientstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $clientstatus . '", "id": "' . $id . '" }';
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


	function getClientList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getClientList($id,$sort);
		$clients = $arr["clients"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["CLIENT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getClientDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getClientDetails($id)) {
			$client = $arr["client"];
			$order_access = $arr["orders_access"];
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


	function printClientDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getClientDetails($id)) {
			$client = $arr["client"];
			$order_access = $arr["orders_access"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $client->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_CLIENT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function printClientHandbook($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		
		if($arr = $this->model->getClientDetails($id)) {
			$client = $arr["client"];
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
			$phasescont = new ClientsPhases("phases");
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
			$clientsDocuments = new ClientsDocuments("documents");
			if($arrdocs = $clientsDocuments->model->getList($id,"0")) {
				$docs = $arrdocs["documents"];
				foreach ($docs as $doc) {
					if($arr = $clientsDocuments->model->getDetails($doc->id)) {
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
			$clientsControlling = new ClientsControlling("controlling");
			if($cont = $clientsControlling->model->getDetails($id)) {
				$tit = $client->title;
				ob_start();
					include 'modules/controlling/view/print.php';
					$html .= ob_get_contents();
				ob_end_clean();
			}
			$title = $client->title . " - " . $lang["CLIENT_HANDBOOK"];
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_CLIENT_MANUAL"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}
	
	function checkinClient($id) {
		if($id != "undefined") {
			return $this->model->checkinClient($id);
		} else {
			return true;
		}
	}

	function getClientSend($id) {
		global $lang;
		if($arr = $this->model->getClientDetails($id, 'prepareSendTo')) {
			$client = $arr["client"];
			$order_access = $arr["orders_access"];
			
			$form_url = $this->form_url;
			$request = "sendClientDetails";
			$to = $client->sendtoTeam;
			$cc = "";
			$subject = $client->title;
			$variable = "";
			$data["error"] = 0;
			$data["error_message"] = "";
			if($client->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $client->sendtoTeamNoEmail;
			}
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}


	function sendClientDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getClientDetails($id)) {
			$client = $arr["client"];
			$order_access = $arr["orders_access"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $client->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_CLIENT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("clients",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newClient($id) {
		$retval = $this->model->newClient($id);
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


	function setClientDetails($id,$title,$management,$management_ct,$team,$team_ct,$address,$address_ct,$billingaddress,$billingaddress_ct,$protocol,$folder,$contract) {
		$retval = $this->model->setClientDetails($id,$title,$management,$management_ct,$team,$team_ct,$address,$address_ct,$billingaddress,$billingaddress_ct,$protocol,$folder,$contract);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '"}';
		  } else{
			 return "error";
		  }
	}


	function binClient($id) {
		$retval = $this->model->binClient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreClient($id) {
		$retval = $this->model->restoreClient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteClient($id) {
		$retval = $this->model->deleteClient($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveClient($id,$startdate,$movedays) {
		$retval = $this->model->moveClient($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getClientFolderDialog($field,$title) {
		$retval = $this->model->getClientFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getClientStatusDialog() {
		global $lang;
		include 'view/dialog_client_status.php';
	}
	
	function getClientContractDialog() {
		global $lang;
		include 'view/dialog_client_contract.php';
	}
	
	function getAccessOrdersDialog($request,$field,$append,$title,$sql) {
		global $lang;
		include 'view/dialog_access_orders.php';
	}
	
	
	function generateAccess($id,$cid) {
		global $lang, $session, $contactsmodel;
		
		$username = $session->generateAccessUsername(4);
		$password = $session->generateAccessPassword(4);
		
		$to = $id;
		$from = $contactsmodel->getContactFieldFromID($session->uid, 'email');
		$fromName = $contactsmodel->getContactFieldFromID($session->uid, 'firstname') . " " . $contactsmodel->getContactFieldFromID($session->uid, 'lastname');
		$subject = $lang['CLIENT_ACCESS_CODES_EMAIL_SUBJECT'];
		$body = sprintf($lang['CLIENT_ACCESS_CODES_EMAIL'], 'https://mama-bringts.companyobserver.com/?path=api/apps/publishers/menues/orders', $username, $password);
		
		$email = $this->sendEmail($to,$cc="",$from,$fromName,$subject,$body);
		
		// now save to db
		$save = $this->model->setContactAccessDetails($id,$cid,$username,$password);
		
		$now = $this->model->_date->formatDate(gmdate("Y-m-d"),CO_DATE_FORMAT);
		//$now = "now";
		$user = $contactsmodel->getUserFullname($session->uid);
		
		echo sprintf($lang['CONTACTS_ACCESS_ACTIVE'], $now, $user);
	}
	
	
	function removeAccess($id,$cid) {
		global $lang, $session;
		// now save to db
		$save = $this->model->removeAccess($id,$cid);
		//$now = $this->model->_date->formatDate(gmdate("Y-m-d"),CO_DATE_FORMAT);
		//$user = $this->model->getUserFullname($session->uid);
		//echo sprintf($lang['CONTACTS_ACCESS_REMOVE'], $now, $user);
		echo($lang['CONTACTS_ACCESSCODES_NO']);
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
	
	
	function getClientsHelp() {
		global $lang;
		$data["file"] = $lang["CLIENT_HELP"];
		$data["app"] = "clients";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getClientsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["CLIENT_FOLDER_HELP"];
		$data["app"] = "clients";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $clients;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $clients;
		if($arr = $this->model->emptyBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function getExportWindow($id) {
		global $lang;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$clients = $arr["clients"];	
			include 'view/dialog_export.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}	
	
	// User Access
	function isAdmin(){
	  global $session;
	  /*if($this->model->isClientOwner($session->uid)) {
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
	   global $clients;
	   $retval = $this->model->getCheckpointDetails($app,$module,$id);
	   if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
   }


	function getClientsSearch($term,$exclude) {
		$search = $this->model->getClientsSearch($term,$exclude);
		return $search;
	}
	
	function saveLastUsedClients($id) {
		$retval = $this->model->saveLastUsedClients($id);
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

$clients = new Clients("clients");
?>