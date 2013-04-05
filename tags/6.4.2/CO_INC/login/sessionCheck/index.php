<?php
include_once(CO_INC . "/classes/session.php");
// check if this page is called through ajax
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest')) {
	die('no ajax call');
}

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'sessionCheck':
			$data = array();
			$data["active"] = false;
			if($session->logged_in){
				$data["active"] = true;
			}
			// coohie deleted???
			if($data["active"] == false && empty($_SESSION['username'])) {
			
			} else {
				$data["user"] = $_SESSION['username'];
			}
			echo json_encode($data);
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'reactivateLogin':
			  $retval = $session->login($_POST['user'], $_POST['pass'], isset($_POST['remember']));
			  if($retval){
				 echo true;
			  } else{
				 echo false;
			  }
		break;
		case 'logout':
			  $retval = $session->logout();
			  echo true;
		break;
	}
}
?>