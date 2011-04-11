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


// get dependend module phases
					include_once("../phases/config.php");
					//include_once("../phases/lang/" . $session->userlang . ".php");
					include_once("../phases/model.php");
					include_once("../phases/controller.php");


// Phonecalls
include_once("config.php");
include_once("lang/" . $session->userlang . ".php");
include_once("model.php");
include_once("controller.php");
$phonecalls = new Phonecalls("phonecalls");

// GET requests
if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($phonecalls->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($phonecalls->getDetails($_GET['id']));
		break;
		case 'getNew':
			echo($phonecalls->getNew($_GET['id']));
		break;
		case 'binPhonecall':
			echo($phonecalls->binPhonecall($_GET['id']));
		break;
		case 'toggleIntern':
			echo($phonecalls->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'insertTask':
			echo($phonecalls->insertTask($_GET['num']));
		break;
	}
}

// POST requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
		
			$task_id = array();
			$task_text = array();
			$task = array();
			
			$task_idnew = array();
			$task_textnew = array();
			$task_new = array();
			
			if(isset($_POST['task_idnew'])) {
				$task_idnew = $_POST['task_idnew'];
				$task_textnew = $_POST['task_textnew'];
			}
			if(isset($_POST['task_new'])) {
				$task_new = $_POST['task_new'];
			}
			
			if(isset($_POST['task_id'])) {
				$task_id = $_POST['task_id'];
				$task_text = $_POST['task_text'];
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			echo($phonecalls->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['phonecall_date'],$task_idnew,$task_textnew,$task_new,$task_id,$task_text,$task));
		break;
		case 'createNew':
			echo($phonecalls->createNew($_POST['id'],$_POST['title'],$_POST['phonecall_date']));
		break;
	}
}

?>