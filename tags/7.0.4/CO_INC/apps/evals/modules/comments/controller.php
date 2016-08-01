<?php

class EvalsComments extends Evals {
	var $module;

	function __construct($name) {
			$this->module = $name;
			$this->form_url = "apps/evals/modules/$name/";
			$this->model = new EvalsCommentsModel();
			$this->binDisplay = true;
	}


	function getList($id,$sort) {
		global $system, $lang;
		$arr = $this->model->getList($id,$sort);
		$comments = $arr["comments"];
		ob_start();
			include('view/list.php');
			$data["html"] = ob_get_contents();
		ob_end_clean();
		$data["items"] = $arr["items"];
		$data["sort"] = $arr["sort"];
		$data["perm"] = $arr["perm"];
		$data["title"] = $lang["EVAL_COMMENT_ACTION_NEW"];
		return $system->json_encode($data);
	}


	function getDetails($id) {
		global $lang;
		if($arr = $this->model->getDetails($id)) {
			$comment = $arr["comment"];
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
			$comment = $arr["comment"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $comment->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["EVAL_PRINT_COMMENT"];
		switch($t) {
			case "html":
				$this->printHTML($title,$html);
			break;
			default:
				$this->printPDF($title,$html);
		}
	}
	
	function getSend($id) {
		global $lang;
		if($arr = $this->model->getDetails($id,'prepareSendTo')) {
			$comment = $arr["comment"];			
			$form_url = $this->form_url;
			$request = "sendDetails";
			$to = $comment->sendtoTeam;
			$cc = "";
			$subject = $comment->title;
			$variable = "";
			
			$data["error"] = 0;
			$data["error_message"] = "";
			if($comment->sendtoTeamNoEmail != "") {
				$data["error"] = 1;
				$data["error_message"] = $comment->sendtoTeamNoEmail;
			}
			ob_start();
				include CO_INC .'/view/dialog_send.php';
				$data["html"] = ob_get_contents();
			ob_end_clean();
			return json_encode($data);
		}
	}

	
	
	function sendDetails($id,$variable,$to,$cc,$subject,$body) {
		global $session, $users, $lang;
		$title = "";
		$html = "";
		if($arr = $this->model->getDetails($id)) {
			$comment = $arr["comment"];
			$sendto = $arr["sendto"];
			ob_start();
				include 'view/print.php';
				$html = ob_get_contents();
			ob_end_clean();
			$title = $comment->title;
		}
		$GLOBALS['SECTION'] = $session->userlang . "/" . $lang["EVAL_PRINT_COMMENT"];
		$attachment = CO_PATH_PDF . "/" . $this->normal_chars($title) . ".pdf";
		$pdf = $this->savePDF($title,$html,$attachment);
		
		// write sento log
		$this->writeSendtoLog("evals_comments",$id,$to,$subject,$body);
		
		//$to,$from,$fromName,$subject,$body,$attachment
		return $this->sendEmail($to,$cc,$session->email,$session->firstname . " " . $session->lastname,$subject,$body,$attachment);
	}


	function checkinComment($id) {
		if($id != "undefined") {
			return $this->model->checkinComment($id);
		} else {
			return true;
		}
	}
	

	function setDetails($pid,$id,$title,$commentdate,$protocol,$management,$management_ct,$documents,$comment_access,$comment_access_orig) {
		if($arr = $this->model->setDetails($pid,$id,$title,$commentdate,$protocol,$management,$management_ct,$documents,$comment_access,$comment_access_orig)){
			return '{ "action": "edit" , "id": "' . $arr["id"] . '", "access": "' . $comment_access . '"}';
		} else{
			return "error";
		}
	}


	function createNew($id) {
		$retval = $this->model->createNew($id);
		if($retval){
			 return '{ "what": "comment" , "action": "new", "id": "' . $retval . '" }';
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


	function binComment($id) {
		$retval = $this->model->binComment($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}

	function restoreComment($id) {
		$retval = $this->model->restoreComment($id);
		if($retval){
			 return "true";
		  } else{
			 return "error";
		  }
	}
	
	function deleteComment($id) {
		$retval = $this->model->deleteComment($id);
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

	
	function getCommentStatusDialog() {
		global $lang;
		include 'view/dialog_status.php';
	}


	function getHelp() {
		global $lang;
		$data["file"] =  $lang["EVAL_COMMENT_HELP"];
		$data["app"] = "evals";
		$data["module"] = "/modules/comments";
		$this->openHelpPDF($data);
	}
	
}

$evalsComments = new EvalsComments("comments");
?>