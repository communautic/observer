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
	}
	
	function getGroupList($sort) {
		global $system;
		$arr = $this->model->getGroupList($sort);
		$groups = $arr["groups"];
		ob_start();
			include('view/groups_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}
	
	function getGroupDetails($id) {
		global $lang;
		if($group = $this->model->getGroupDetails($id)) {
			include 'view/group_edit.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}

	
	function newGroup() {
		$retval = $this->model->newGroup();
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
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
		global $system;
		$arr = $this->model->getContactList($sort);
		$contacts = $arr["contacts"];
		ob_start();
			include('view/contact_list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		return $system->json_encode($data);
	}

	function getContactDetails($id) {
		global $lang;
		if($contact = $this->model->getContactDetails($id)) {
			include 'view/contact_edit.php';
		} else {
			include CO_INC .'/view/default.php';
		}
	}


	function getContactVCard($id) {
		$vcardString = '';
		$contact = $this->model->getContactDetails($id);
		 $data['BEGIN'] = 'VCARD';
    $data['VERSION'] = '3.0';
    $data['PRODID'] = '-//company contact export Version 1//EN';
    $data['REV'] = date('Y-m-d H:i:s');
    $data['TZ'] = date('O');
 
    $data['FN'] = $contact->firstname . " " . $contact->lastname;
    $data['N'] = $contact->lastname.';'.$contact->firstname;
 
    if ($this->getTitle() != '') {
        $data['TITLE'] = $contact->title;
    }
 
    //foreach ($this->getMailAddresses() as $mailAddress) {
        $data['EMAIL;TYPE=internet'] = $contact->email;
    //}
 
    /*if ($this->getNotice() != '') {
        $data['NOTE'] = $this->getNotice();
    }*/
 
    $data['END'] = 'VCARD';
 
    $exportString = '';
    foreach ($data as $index => $value) {
        $exportString .= $index . ':' . $value . "\r\n";
    }
 
    return $exportString;
	 
		//if (count($contacts) == 1) {
			$filename = str_replace(" ", "_", $contact->firstname.' '.$contact->lastname);
		/*} else {
			$filename = 'VCARDS';
		}*/
	 
		header('Content-Type', 'text/x-vCard; charset=utf-8');
		header('Content-Disposition', 'attachment; filename="'.$filename.'.vcf"');
		header('Content-Length', strlen($vcardString));
		header('Connection', 'close');
		//$this->getResponse()->setBody($vcardString);
		//file_put_contents( $path, $pdf);
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
	
	
	function setContactDetails($id, $lastname, $firstname, $title, $company, $position, $email, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang,$timezone) {
		$retval = $this->model->setContactDetails($id, $lastname, $firstname, $title, $company, $position, $email, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang,$timezone);
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
	
	function getContactsDialog($request,$field,$append,$title,$sql) {
		global $lang;
		$list = $this->model->getContactsDialog($request,$field,$append,$title,$sql);
		include_once dirname(__FILE__).'/view/dialog_contacts.php';
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
	
	function getUserContext($id,$field) {
		global $lang;
		$context = $this->model->getUserContext($id,$field);
		include 'view/contact_context.php';
	}
	
	function getContactsSearch($term) {
		$search = $this->model->getContactsSearch($term);
		return $search;
	}
	
	function getPlacesSearch($term) {
		$search = $this->model->getPlacesSearch($term);
		return $search;
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
	
}

$contacts = new Contacts("contacts");
?>