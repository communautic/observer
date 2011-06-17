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

include_once(CO_INC . "/apps/projects/modules/meetings/config.php");
include_once(CO_INC . "/apps/projects/modules/meetings/lang/" . $session->userlang . ".php");

include_once(CO_INC . "/apps/projects/modules/controlling/config.php");
include_once(CO_INC . "/apps/projects/modules/controlling/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/controlling/model.php");
include_once(CO_INC . "/apps/projects/modules/controlling/controller.php");

$projectsControlling = new ProjectsControlling("controlling");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsControlling->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($projectsControlling->getDetails($_GET['id'],$_GET['pid']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projectsControlling->printDetails($_GET['id'],$_GET['pid'],$t));
		break;
		case 'getSend':
			echo($projectsControlling->getSend($_GET['id'],$_GET['pid']));
		break;
		case 'getSendtoDetails':
			echo($projectsControlling->getSendtoDetails("controlling",$_GET['id']));
		break;
		case 'getDailyStatistic':
			$md5 = "8434a915e0326f424aa8228c9261524e";
			$k = $_GET['k'];
			if($md5 != $k) {
				exit();
			}
			echo($projectsControlling->getDailyStatistic());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'sendDetails':
			echo($projectsControlling->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>