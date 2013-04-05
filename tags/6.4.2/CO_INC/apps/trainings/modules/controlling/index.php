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
include_once(CO_INC . "/apps/trainings/modules/feedbacks/config.php");
include_once(CO_INC . "/apps/trainings/modules/feedbacks/lang/" . $session->userlang . ".php");

include_once(CO_INC . "/apps/trainings/modules/meetings/config.php");
include_once(CO_INC . "/apps/trainings/modules/meetings/lang/" . $session->userlang . ".php");

include_once(CO_INC . "/apps/trainings/modules/controlling/config.php");
include_once(CO_INC . "/apps/trainings/modules/controlling/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/trainings/modules/controlling/model.php");
include_once(CO_INC . "/apps/trainings/modules/controlling/controller.php");

$trainingsControlling = new TrainingsControlling("controlling");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainingsControlling->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($trainingsControlling->getDetails($_GET['id'],$_GET['pid']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainingsControlling->printDetails($_GET['id'],$_GET['pid'],$t));
		break;
		case 'getSend':
			echo($trainingsControlling->getSend($_GET['id'],$_GET['pid']));
		break;
		case 'getSendtoDetails':
			echo($trainingsControlling->getSendtoDetails("trainings_controlling",$_GET['id']));
		break;
		case 'getDailyStatistic':
			$md5 = "8434a915e0326f424aa8228c9261524e";
			$k = $_GET['k'];
			if($md5 != $k) {
				exit();
			}
			echo($trainingsControlling->getDailyStatistic());
		break;
		case 'getHelp':
			echo($trainingsControlling->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'sendDetails':
			echo($trainingsControlling->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>