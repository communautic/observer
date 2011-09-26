<?php

class BrainstormsForums extends Brainstorms {
	var $module;


	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/brainstorms/modules/$name/";
			$this->model = new BrainstormsForumsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$forums = $arr["forums"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["BRAINSTORM_FORUM_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id,$view) {
		global $lang, $system;
		if($arr = $this->model->getDetails($id,$view)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			//$sendto = $arr["sendto"];
			//include('view/edit.php');
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


	function printDetails($id,$num,$t) {
		global $session, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id,$num)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $forum->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["BRAINSTORM_PRINT_FORUM"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	function getSend($id,$num) {
		global $lang;
		if($arr = $this->model->getDetails($id,$num)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = "";
			$cc = "";
			$subject = $forum->title;
			$variable = $num;
			
			include CO_INC .'/view/dialog_send.php';
		}
		else {
			include CO_INC .'/view/default.php';
		}
	}


	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session,$users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id,$variable)) {
			$forum = $arr["forum"];
			$posts = $arr["posts"];
			$answers = $arr["answers"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $forum->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["BRAINSTORM_PRINT_FORUM"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("brainstorms_forums",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}
	
	/*function checkinForum($id) {
		if($id != "undefined") {
			return $this->model->checkinForum($id);
		} else {
			return true;
		}
	}*/


	function setDetails($id,$title,$protocol,$documents,$forum_access,$forum_access_orig,$forum_status,$forum_status_date) {
		if($arr = $this->model->setDetails($id,$title,$protocol,$documents,$forum_access,$forum_access_orig,$forum_status,$forum_status_date)){
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $forum_access . '", "status": "' . $forum_status . '"}';
			//return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $forum_access . '", "status": "' . $forum_status . '", "startdate": "' . $arr["startdate"] . '", "enddate": "' . $arr["enddate"] . '"}';

			//return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $forum_access . '", "status": "' . $forum_status . '"}';
		  } else{
			 return "error";
		  }
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "forum" , "action": "new", "id": "' . $retval . '" }';
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


	function toggleIntern($id,$status) {
		$retval = $this->model->toggleIntern($id,$status);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}


	function getForumTaskDialog() {
		global $lang;
		include 'view/dialog_task.php';
	}


	function getTasksDialog($id,$field) {
		$retval = $this->model->getTasksDialog($id,$field);
		if($retval){
			 return $retval;
		  } else{
			 return "error";
		  }
	}
	
	function getTaskDependencyExists($id) {
		$retval = $this->model->getTaskDependencyExists($id);
		//return $retval;
		if($retval){
			 return "true";
		  } else{
			 return "false";
		  }
	}
	
	function moveDependendTasks($id,$days) {
		$retval = $this->model->moveDependendTasks($id,$days);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}

	function addItem($id,$text,$replyid,$num) {
		global $lang;
		$checked = "";
		$postdellink = '';
		$postdelclass = 'icon-delete';
		if($replyid == 0) {
			if($post = $this->model->addItem($id,$text,$replyid,$num)) {
				$data["itemid"] = $post->id;
				ob_start();
					include 'view/post.php';
					$data["html"] = ob_get_contents();
				ob_end_clean();
			}
		} else {
			if($child = $this->model->addItem($id,$text,$replyid,$num)) {
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


	function binItem($id) {
		$retval = $this->model->binItem($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function deleteForumTask($id) {
		$retval = $this->model->deleteForumTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function restoreForumTask($id) {
		$retval = $this->model->restoreForumTask($id);
		if($retval){
			return "true";
		} else{
			return "error";
		}
	}


	function getForumStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}

	function getForumsBin($id) {
		$arr = $this->model->getForumsBin($id);
		return $arr;
		/*if($retval){
			return "true";
		} else{
			return "error";
		}*/
		//return $this->model->getBin($id);
	}


	function getHelp() {
		global $lang;
		$data["file"] =  $lang["BRAINSTORM_FORUM_HELP"];
		$data["app"] = "brainstorms";
		$data["module"] = "/modules/forums";
		$this->openHelpPDF($data);
	}

}

$brainstormsForums = new BrainstormsForums("forums");
?>