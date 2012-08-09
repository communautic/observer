<?php

class Contacts extends Controller {
	
	// get all available apps
	function __construct($name) {
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ContactsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			$this->contactsDisplay = false; // list access status on contact page
	}
	
	function getGroupList($sort) {
		global $system, $lang;
		$arr = $this->model->getGroupList($sort);
		$groups = $arr["groups"];
		ob_start();
			include('view/groups_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["CONTACTS_GROUPS_ACTION_NEW"];
		return $system->json_encode($data);
	}
	
	function getGroupDetails($id) {
		global $lang;
		if($group = $this->model->getGroupDetails($id)) {
			$members = "";
			if(!empty($group->membersID))  {
				$membersarray = explode(",", $group->membersID);
				foreach ($membersarray as &$value) {
					if($contact = $this->model->getContactDetails($value)) {
					$members[] = array("id" => $contact->id, "name" => $contact->lastname." ".$contact->firstname, "email" => $contact->email, "phone" => $contact->phone1);
					}
				}
			}
			include 'view/group_edit.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function getGroupMemberDetails($id) {
		global $lang;
		if($group = $this->model->getGroupDetails($id)) {
		$members = "";
			if(!empty($group->membersID))  {
				$membersarray = explode(",", $group->membersID);
				foreach ($membersarray as &$value) {
					if($contact = $this->model->getContactDetails($value)) {
					$members[] = array("id" => $contact->id, "name" => $contact->lastname." ".$contact->firstname, "email" => $contact->email, "username" => $contact->username, "userlevel" => $contact->userlevel);
					}
				}
			}
		}
		return json_encode($members);
	}
	
	
	function printGroupDetails($id, $t) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($group = $this->model->getGroupDetails($id)) {
			$members = "";
			if(!empty($group->membersID))  {
				$membersarray = explode(",", $group->membersID);
				foreach ($membersarray as &$value) {
					$contact = $this->model->getContactDetails($value);
					$members[] = array("id" => $contact->id, "name" => $contact->lastname." ".$contact->firstname, "email" => $contact->email, "phone" => $contact->phone1);
				}
			}
			ob_start();
				include 'view/group_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $group->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_GROUP"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


	function getGroupSend($id) {
		global $lang;
		if($group = $this->model->getGroupDetails($id)) {
			$form_url = $this->form_url;
			$request = "sendGroupDetails";
			$to = "";
			$cc = "";
			$subject = $group->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendGroupDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($group = $this->model->getGroupDetails($id)) {
			$members = "";
			if(!empty($group->membersID))  {
				$membersarray = explode(",", $group->membersID);
				foreach ($membersarray as &$value) {
					$contact = $this->model->getContactDetails($value);
					$members[] = array("id" => $contact->id, "name" => $contact->lastname." ".$contact->firstname, "email" => $contact->email, "phone" => $contact->phone1);
				}
			}
			ob_start();
				include 'view/group_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $group->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_GROUP"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("projects",$id,$to);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function getGroupSendVcard($id) {
		global $lang;
		if($group = $this->model->getGroupDetails($id)) {
			$form_url = $this->form_url;
			$request = "sendGroupDetailsVcard";
			$to = "";
			$cc = "";
			$subject = $group->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function sendGroupDetailsVcard($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		
		if($group = $this->model->getGroupDetails($id)) {
			/*ob_start();
				include 'view/group_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $contact->lastname . "_" . $contact->firstname;*/
			$vcards_array = "";
			$users = explode(",", $group->membersID);
			foreach ($users as &$value) {
				$contact = $this->model->getContactDetails($value);
				$vcards_array[] = array("path" => $this->saveContactVCard($value), "filename" => $contact->firstname."_".$contact->lastname . ".vcf");
			}
		}
		//$GLOBALS['SECTION'] = "projekt.png";
		$attachment = "";
		$attachment_array = "";
		
		// write sento log
		//$this->writeSendtoLog("projects",$id,$to);
		
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment,$attachment_array,$vcards_array);
	}


	
	function newGroup() {
		$retval = $this->model->newGroup();
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function duplicateGroup($id) {
		$retval = $this->model->duplicateGroup($id);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function setGroupDetails($id,$title,$members) {
		$retval = $this->model->setGroupDetails($id,$title,$members);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binGroup($id) {
		$retval = $this->model->binGroup($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreGroup($id) {
		$retval = $this->model->restoreGroup($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteGroup($id) {
		$retval = $this->model->deleteGroup($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	
	function getContactList($sort) {
		global $system, $lang;
		$arr = $this->model->getContactList($sort);
		$contacts = $arr["contacts"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["CONTACTS_CONTACTS_ACTION_NEW"];
		return $system->json_encode($data);
	}

	function getContactDetails($id,$applications="") {
		global $lang, $session;
		if($contact = $this->model->getContactDetails($id,$applications)) {
			include 'view/edit.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function getContactField($id,$field) {
		global $lang, $session;
		echo $this->model->getContactFieldFromID($id,$field);
	}
	
	function getContactDetailsArray($id) {
		global $lang;
		if($contact = $this->model->getContactDetails($id)) {
		$details = "";
		$details = array("id" => $contact->id, "name" => $contact->lastname." ".$contact->firstname, "email" => $contact->email, "username" => $contact->username, "userlevel" => $contact->userlevel);
		}
		return json_encode($details);
	}
	
	function printContactDetails($id, $t) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($contact = $this->model->getContactDetails($id)) {
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $contact->lastname . "_" . $contact->firstname;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_CONTACT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}


function getContactSend($id) {
		global $lang;
		if($contact = $this->model->getContactDetails($id)) {
			$form_url = $this->form_url;
			$request = "sendContactDetails";
			$to = "";
			$cc = "";
			$subject = $contact->lastname . " " . $contact->firstname;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendContactDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($contact = $this->model->getContactDetails($id)) {
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $contact->lastname . "_" . $contact->firstname;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_CONTACT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("projects",$id,$to);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	function getContactSendVcard($id) {
		global $lang;
		if($contact = $this->model->getContactDetails($id)) {
			$form_url = $this->form_url;
			$request = "sendContactDetailsVcard";
			$to = "";
			$cc = "";
			$subject = $contact->lastname . " " . $contact->firstname;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	
	function sendContactDetailsVcard($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		
		/*if($contact = $this->model->getContactDetails($id)) {
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $contact->lastname . "_" . $contact->firstname;
		}*/
		//$GLOBALS['SECTION'] = "projekt.png";
		$attachment = $this->saveContactVCard($id);
		
		// write sento log
		//$this->writeSendtoLog("projects",$id,$to);
		
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	

	function saveContactVCard($id) {
		$vcardString = '';
		$contact = $this->model->getContactDetails($id);
		$data['BEGIN'] = 'VCARD';
   		$data['VERSION'] = '3.0';
    	$data['N'] = $contact->lastname.';'.$contact->firstname;
		$data['FN'] = $contact->firstname . " " . $contact->lastname;
		$data['ORG'] = $contact->company;
		$data['TITLE'] = $contact->title;
		//PHOTO;VALUE=URL;TYPE=GIF:http://www.example.com/dir_photos/my_photo.gif
		$data['TEL;type=CELL;type=pref'] = $contact->phone1;
		$data['TEL;type=WORK'] = $contact->phone2;
        $data['EMAIL;TYPE=internet'] = $contact->email;
    	$data['END'] = 'VCARD';
 
    $exportString = '';
    foreach ($data as $index => $value) {
        $exportString .= $index . ':' . $value . "\r\n";
    }
 

	$filename = $contact->firstname."_".$contact->lastname . ".vcf";

		$path = CO_PATH_DATA . "vcards/".$filename;
		file_put_contents($path, $exportString);
	 	return $path;
	}


	function getContactNew($id) {
		$contact = $this->model->getContactNew($id);
		include 'view/contact_new.php';
	}
	
	function newContact() {
		$retval = $this->model->newContact();
		if($retval){
			 $num = $this->model->getNumAllContacts();
			 return '{ "action": "new", "id": "' . $retval . '", "num": "' . $num . '"}';
		  } else{
			 return "error";
		  }
	}
	
	
	function duplicateContact($id) {
		$retval = $this->model->duplicateContact($id);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	
	function setContactDetails($id, $lastname, $firstname, $title, $title2, $company, $position, $email, $email_alt, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang,$timezone) {
		$retval = $this->model->setContactDetails($id, $lastname, $firstname, $title, $title2, $company, $position, $email, $email_alt, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang,$timezone);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binContact($id) {
		$retval = $this->model->binContact($id);
		if($retval){
			$num = $this->model->getNumAllContacts();
			 return '{ "status": "true", "num": "' . $num . '"}';
		  } else{
			 return "error";
		  }
	}


	function restoreContact($id) {
		$retval = $this->model->restoreContact($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteContact($id) {
		$retval = $this->model->deleteContact($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	
	function getLanguageDialog($request,$field,$append,$title,$sql) {
		include_once dirname(__FILE__).'/view/dialog_languages.php';
	}
	
	function getTimezoneDialog($request,$field,$append,$title,$sql) {
		include_once dirname(__FILE__).'/view/dialog_timezones.php';
	}
	
	function getAccessDialog($request,$field,$append,$title,$sql) {
		global $lang;
		include_once dirname(__FILE__).'/view/dialog_access.php';
	}
	
	function getSysadminDialog($request,$field,$append,$title,$sql) {
		global $lang;
		include_once dirname(__FILE__).'/view/dialog_sysadmin.php';
	}
	
	function getContactsDialog($request,$field,$append,$title,$sql) {
		global $lang;
		$groups = $this->model->getLast10Groups();
		$contacts = $this->model->getLast10Contacts();
		include_once dirname(__FILE__).'/view/dialog_contacts.php';
	}
	
	function saveLastUsedContacts($id) {
		$retval = $this->model->saveLastUsedContacts($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}


	function saveLastUsedGroups($id) {
		$retval = $this->model->saveLastUsedGroups($id);
		if($retval){
		   return "true";
		} else{
		   return "error";
		}
	}


	function getContactsDialogPlace($request,$field,$append,$title,$sql) {
		global $lang;
		include_once dirname(__FILE__).'/view/dialog_places.php';
	}
	
	function getUserFromDialog($id) {
		$retval = $this->model->getUserFromDialog($id);
		return $retval;
	}
	
	function getUsersInGroupDialog($id,$field) {
		$retval = $this->model->getUsersInGroupDialog($id,$field);
		return $retval;
	}
	
	function getUserContext($id,$field,$edit) {
		global $lang;
		$context = $this->model->getUserContext($id,$field);
		include 'view/contact_context.php';
	}
	
	function getContactsSearch($term) {
		$search = $this->model->getContactsSearch($term);
		return $search;
	}
	
	function getGroupsSearch($term) {
		$search = $this->model->getGroupsSearch($term);
		return $search;
	}
	
	function getPlacesSearch($term) {
		$search = $this->model->getPlacesSearch($term);
		return $search;
	}
	
	function getContactsHelp() {
		global $lang;
		$data["file"] = $lang["CONTACTS_HELP"];
		$data["app"] = "contacts";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getContactsGroupsHelp() {
		global $lang;
		$data["file"] =  $lang["PCONTACTS_GROUPS_HELP"];
		$data["app"] = "contacts";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getBin() {
		global $lang,$contacts;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $contacts;
		if($arr = $this->model->emptyBin()) {
			$bin = $arr["bin"];
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function generateAccess($id) {
		global $lang, $session;
		
		$username = $session->generateAccessUsername(4);
		$password = $session->generateAccessPassword(4);
		
		$to = $id;
		$from = $this->model->getContactFieldFromID($session->uid, 'email');
		$fromName = $this->model->getContactFieldFromID($session->uid, 'firstname') . " " . $this->model->getContactFieldFromID($session->uid, 'lastname');
		$subject = $lang['ACCESS_CODES_EMAIL_SUBJECT'];
		$body = sprintf($lang['ACCESS_CODES_EMAIL'], CO_PATH_URL, $username, $password);
		
		$email = $this->sendEmail($to,$cc="",$from,$fromName,$subject,$body);
		
		// now save to db
		$save = $this->model->setContactAccessDetails($id,$username,$password);
		
		$now = $this->model->_date->formatDate(gmdate("Y-m-d"),CO_DATE_FORMAT);
		//$now = "now";
		$user = $this->model->getUserFullname($session->uid);
		
		echo sprintf($lang['CONTACTS_ACCESS_ACTIVE'], $now, $user);
	}
	
	
	function removeAccess($id) {
		global $lang, $session;
		// now save to db
		$save = $this->model->removeAccess($id);
		$now = $this->model->_date->formatDate(gmdate("Y-m-d"),CO_DATE_FORMAT);
		$user = $this->model->getUserFullname($session->uid);
		echo sprintf($lang['CONTACTS_ACCESS_REMOVE'], $now, $user);
	}
	
	function setSysadmin($id) {
		global $lang, $session;
		// now save to db
		$save = $this->model->setSysadmin($id);
		$now = $this->model->_date->formatDate(gmdate("Y-m-d"),CO_DATE_FORMAT);
		$user = $this->model->getUserFullname($session->uid);
		echo sprintf($lang['CONTACTS_SYSADMIN_ACTIVE'], $now, $user);
	}
	
	function removeSysadmin($id) {
		global $lang, $session;
		// now save to db
		$save = $this->model->removeSysadmin($id);
		$now = $this->model->_date->formatDate(gmdate("Y-m-d"),CO_DATE_FORMAT);
		$user = $this->model->getUserFullname($session->uid);
		echo sprintf($lang['CONTACTS_SYSADMIN_REMOVE'], $now, $user);
	}
	
	function binItem($id) {
		$retval = $this->model->binItem($id);
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
	
	function restoreItem($id) {
		$retval = $this->model->restoreItem($id);
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

$contacts = new Contacts("contacts");
?>