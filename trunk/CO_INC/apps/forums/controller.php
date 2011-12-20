<?php

//include_once("lang/" . $session->userlang . ".php");

class Forums extends Controller {

	// get all available apps
	function __construct($name) {
			global $session;
			//parent::__construct();
			$this->application = $name;
			$this->form_url = "apps/$name/";
			$this->model = new ForumsModel();
			$this->modules = $this->getModules($this->application);
			$this->num_modules = sizeof((array)$this->modules);
			$this->binDisplay = true;
			
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
		$data["title"] = $lang["FORUM_FOLDER_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getFolderDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getFolderDetails($id)) {
			$folder = $arr["folder"];
			$forums = $arr["forums"];
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
			$forums = $arr["forums"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_FORUM_FOLDER"];
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
			$forums = $arr["forums"];	
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
			$forums = $arr["forums"];
			//$sendto = $arr["sendto"];
			ob_start();
				include 'view/folder_print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $folder->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_FORUM_FOLDER"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		//$this->writeSendtoLog("forums",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}

	function newFolder() {
		global $session;
		$retval = $this->model->newFolder();
		if($retval){
			// write action log
			//$this->model->writeActionLog($session->uid,"forums","");
			return '{ "action": "new", "id": "' . $retval . '" }';
		} else{
			 return "error";
		}
	}


	function setFolderDetails($id,$title,$forumstatus) {
		$retval = $this->model->setFolderDetails($id,$title,$forumstatus);
		sleep(1);
		if($retval){
			 return '{ "action": "edit", "status": "' . $forumstatus . '", "id": "' . $id . '" }';
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


	function getForumList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getForumList($id,$sort);
		$forums = $arr["forums"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["title"] = $lang["FORUM_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getForumDetails($id) {
		global $lang, $system;
		if($arr = $this->model->getForumDetails($id)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			//$sendto = $arr["sendto"];
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
		
		if($forum = $this->model->getDates($id)) {
			return json_encode($forum);
		}
	}


	function printForumDetails($id, $t) {
		global $session,$lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getForumDetails($id)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $forum->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_FORUM"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
		
	}

	function checkinForum($id) {
		if($id != "undefined") {
			return $this->model->checkinForum($id);
		} else {
			return true;
		}
	}

	function getForumSend($id) {
		global $lang;
		if($arr = $this->model->getForumDetails($id)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			
			$form_url = $this->form_url;
			$request = "sendForumDetails";
			$to = "";
			$cc = "";
			$subject = $forum->title;
			$variable = "";
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendForumDetails($id,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getForumDetails($id)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $forum->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["PRINT_FORUM"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("forums",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function newForum($id) {
		$retval = $this->model->newForum($id);
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


	function setForumDetails($id,$folder,$title,$protocol,$status,$forumsstatus_date) {
		if($arr = $this->model->setForumDetails($id,$folder,$title,$protocol,$status,$forumsstatus_date)) {
			 return '{ "action": "edit" , "id": "' . $arr["id"] . '", "status": "' . $status . '"}';
		  } else{
			 return "error";
		  }
	}


	function binForum($id) {
		$retval = $this->model->binForum($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function restoreForum($id) {
		$retval = $this->model->restoreForum($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function deleteForum($id) {
		$retval = $this->model->deleteForum($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}	


	function moveForum($id,$startdate,$movedays) {
		$retval = $this->model->moveForum($id,$startdate,$movedays);
		if($retval){
			 return '{ "action": "reload", "id": "' . $id . '" }';
		  } else{
			 return "error";
		  }
	}


	function getForumFolderDialog($field,$title) {
		$retval = $this->model->getForumFolderDialog($field,$title);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}


	function getForumStatusDialog() {
		global $lang;
		include 'view/dialog_forum_status.php';
	}



	function addForumItem($id,$text,$replyid,$num) {
		global $lang;
		$checked = "";
		$postdellink = '';
		$postdelclass = 'icon-delete';
		if($replyid == 0) {
			if($post = $this->model->addForumItem($id,$text,$replyid,$num)) {
				$data["itemid"] = $post->id;
				ob_start();
					include 'view/post.php';
					$data["html"] = ob_get_contents();
				ob_end_clean();
			}
		} else {
			if($child = $this->model->addForumItem($id,$text,$replyid,$num)) {
				$data["itemid"] = $child->id;
				ob_start();
					include 'view/post_child.php';
					$data["html"] = ob_get_contents();
				ob_end_clean();
			}
		}
		return json_encode($data);
	}
	
	function setItemStatus($id,$status) {
		$retval = $this->model->setItemStatus($id,$status);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function binForumItem($id) {
		$retval = $this->model->binForumItem($id);
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
	
	function deleteItem($id) {
		$retval = $this->model->deleteItem($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	

	function getAccessDialog() {
		global $lang;
		include 'view/dialog_access.php';
	}
	
	
	function getForumsHelp() {
		global $lang;
		$data["file"] = $lang["FORUM_HELP"];
		$data["app"] = "forums";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}
	
	function getForumsFoldersHelp() {
		global $lang;
		$data["file"] =  $lang["FORUM_FOLDER_HELP"];
		$data["app"] = "forums";
		$data["module"] = "";
		$this->openHelpPDF($data);
	}

	function getBin() {
		global $lang, $forums;
		if($arr = $this->model->getBin()) {
			$bin = $arr["bin"];
			
			include 'view/bin.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}
	
	function emptyBin() {
		global $lang, $forums;
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
	  /*if($this->model->isForumOwner($session->uid)) {
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
			$reminders = $arr["reminders"];
			$notices = $arr["notices"];
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

	function markNewPostRead($pid) {
		global $lang, $system;
		$retval = $this->model->markNewPostRead($pid);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}

}

$forums = new Forums("forums");
?>