<?php
class Publishers extends Controller {

	// get all available apps
	function __construct($name) {
		global $session;
		$this->application = $name;
		$this->form_url = "apps/$name/";
		$this->model = new PublishersModel();
		$this->modules = $this->getModules($this->application);
		$this->num_modules = sizeof((array)$this->modules);
		$this->binDisplay = true;
		$this->contactsDisplay = false; // list access status on contact page
		
		if (!$session->isSysadmin()) {
			$this->canView = $this->model->getViewPerms($session->uid);
			$this->canEdit = $this->model->getEditPerms($session->uid);
			$this->canAccess = array_merge($this->canView,$this->canEdit);
		}
	}


	function getAccessDialog() {
		global $lang;
		include 'view/dialog_access.php';
	}
	

	function getBin() {
		global $lang, $publishers;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $publishers;
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

}

$publishers = new Publishers("publishers");
?>