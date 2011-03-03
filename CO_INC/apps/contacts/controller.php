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
		$group = $this->model->getGroupDetails($id);
		if($id == 0) {
			include 'view/system_group.php';
		} else {
			include 'view/group_edit.php';
		}
	}
	
	function getGroupNew() {
		//$group = $this->model->getGroupDetails($id);
		include 'view/group_new.php';
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

	/*function getContactList($id) {
		$contacts = $this->model->getContactList($id);
		include 'view/contacts_list.php';
	}*/
	
	function getContactList($id,$sort) {
		global $system;
		$arr = $this->model->getContactList($id,$sort);
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
	
	function getContactNew($id) {
		$contact = $this->model->getContactNew($id);
		include 'view/contact_new.php';
	}
	
	function newContact() {
		$retval = $this->model->newContact();
		if($retval){
			 return '{ "action": "new", "id": "' . $retval . '" }';
		  } else{
			 return "error";
		  }
	}
	
	
	function setContactDetails($id, $lastname, $firstname, $title, $company, $position, $email, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang) {
		$retval = $this->model->setContactDetails($id, $lastname, $firstname, $title, $company, $position, $email, $phone1, $phone2, $fax, $address_line1, $address_line2, $address_town, $address_postcode, $address_country, $lang);
		if($retval){
			 return '{ "action": "edit", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}
	
	function binContact($id) {
		$retval = $this->model->binContact($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	/*function getPhaseDetails($id,$num) {
		$phase = $this->model->getPhaseDetails($id,$num);
		include 'view/phase_details.php';
	}*/
	
	function testdata() {
		$retval = $this->model->testdataModel();
		return $retval;
	}
	
	function getContactsDialog($request,$field,$append,$title,$sql) {
		$list = $this->model->getContactsDialog($request,$field,$append,$title,$sql);
		include_once dirname(__FILE__).'/view/dialog_contacts.php';
	}
	
	function getContactsDialogPlace($request,$field,$append,$title,$sql) {
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
	
}

$contacts = new Contacts("contacts");
?>