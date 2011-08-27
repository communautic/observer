<?php
include_once(CO_INC . "/classes/ajax_header.inc");
include_once(CO_INC . "/model.php");
include_once(CO_INC . "/controller.php");

foreach($controller->applications as $app => $display) {
	include_once(CO_INC . "/apps/".$app."/config.php");
	include_once(CO_INC . "/apps/".$app."/lang/" . $session->userlang . ".php");
	include_once(CO_INC . "/apps/".$app."/model.php");
	include_once(CO_INC . "/apps/".$app."/controller.php");
}

// needs phases config file for db
include_once(CO_INC . "/apps/projects/modules/phases/config.php");
include_once(CO_INC . "/apps/projects/modules/phases/lang/" . $session->userlang . ".php");

include_once(CO_INC . "/apps/projects/modules/timelines/config.php");
include_once(CO_INC . "/apps/projects/modules/timelines/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/timelines/model.php");
include_once(CO_INC . "/apps/projects/modules/timelines/controller.php");

$projectsTimelines = new ProjectsTimelines("timelines");

// GET requests
if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsTimelines->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			$zoom = 0;
			if(!empty($_GET['zoom'])) {
				$zoom = $_GET['zoom'];
			}
			echo($projectsTimelines->getDetails($_GET['id'],$_GET['pid'],$zoom));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projectsTimelines->printDetails($_GET['id'],$_GET['pid'],$t));
		break;
		case 'getSend':
			echo($projectsTimelines->getSend($_GET['id'],$_GET['pid']));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'sendDetails':
			echo($projectsTimelines->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>