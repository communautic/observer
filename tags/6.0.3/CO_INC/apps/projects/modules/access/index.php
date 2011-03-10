<?php
include_once("../../../../config.php");
include_once(CO_PATH_BASE . "/classes/ajax_header.inc");
include_once("../../../../model.php");
include_once("../../../../controller.php");

foreach($controller->applications as $app => $display) {
	include_once(CO_PATH_BASE."/apps/".$app."/config.php");
	include_once(CO_PATH_BASE."/apps/".$app."/lang/" . $session->userlang . ".php");
	include_once(CO_PATH_BASE."/apps/".$app."/model.php");
	include_once(CO_PATH_BASE."/apps/".$app."/controller.php");
}

include_once("config.php");
include_once("lang/" . $session->userlang . ".php");
include_once("model.php");
include_once("controller.php");
$access = new Access("access");

// GET requests
if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($access->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($access->getDetails($_GET['id'], "28"));
		break;
		case 'getNew':
			echo($access->getNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($access->createDuplicate($_GET['id']));
		break;
		case 'binAccess':
			echo($access->binAccess($_GET['id']));
		break;
		case 'insertTask':
			echo($access->insertTask($_GET['startdate'],$_GET['enddate'],$_GET['num']));
		break;
	}
}

// GET requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			
			$task_startdate = array();
			$task_enddate = array();
			$task_id = array();
			$task_text = array();
			$task = array();
			
			$task_startdatenew = array();
			$task_enddatenew = array();
			$task_idnew = array();
			$task_textnew = array();
			$task_new = array();
			
			if(isset($_POST['task_idnew'])) {
				$task_startdatenew = $_POST['task_startdatenew'];
				$task_enddatenew = $_POST['task_enddatenew'];
				$task_idnew = $_POST['task_idnew'];
				$task_textnew = $_POST['task_textnew'];
			}
			if(isset($_POST['task_new'])) {
				$task_new = $_POST['task_new'];
			}
			
			if(isset($_POST['task_id'])) {
				$task_startdate = $_POST['task_startdate'];
				$task_enddate = $_POST['task_enddate'];
				$task_id = $_POST['task_id'];
				$task_text = $_POST['task_text'];
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			
			echo($access->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['enddate'], $_POST['management'], $_POST['team'], $system->checkMagicQuotes($_POST['protocol']), $_POST['projectstatus'], $_POST['planned_date'], $_POST['inprogress_date'], $_POST['finished_date'],$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new,$task_startdate,$task_enddate,$task_id,$task_text,$task));
		break;
		case 'createNew':
		
			$task_startdatenew = array();
			$task_enddatenew = array();
			$task_idnew = array();
			$task_textnew = array();
			$task_new = array();
			
			if(isset($_POST['task_idnew'])) {
				$task_startdatenew = $_POST['task_startdatenew'];
				$task_enddatenew = $_POST['task_enddatenew'];
				$task_idnew = $_POST['task_idnew'];
				$task_textnew = $_POST['task_textnew'];
			}
			if(isset($_POST['task_new'])) {
				$task_new = $_POST['task_new'];
			}
		
			echo($access->createNew($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['enddate'], $_POST['management'], $_POST['team'], $system->checkMagicQuotes($_POST['protocol']), $_POST['projectstatus'], $_POST['planned_date'], $_POST['inprogress_date'], $_POST['finished_date'],$task_startdatenew,$task_enddatenew,$task_idnew,$task_textnew,$task_new));
		break;
	}
}

?>