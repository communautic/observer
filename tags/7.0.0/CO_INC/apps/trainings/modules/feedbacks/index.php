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

// Feedbacks
include_once(CO_INC . "/apps/trainings/modules/feedbacks/config.php");
include_once(CO_INC . "/apps/trainings/modules/feedbacks/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/trainings/modules/feedbacks/model.php");
include_once(CO_INC . "/apps/trainings/modules/feedbacks/controller.php");
$trainingsFeedbacks = new TrainingsFeedbacks("feedbacks");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainingsFeedbacks->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($trainingsFeedbacks->getDetails($_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainingsFeedbacks->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($trainingsFeedbacks->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($trainingsFeedbacks->getSendtoDetails("trainings_feedbacks",$_GET['id']));
		break;
		case 'getHelp':
			echo($trainingsFeedbacks->getHelp());
		break;
		case 'updateQuestion':
			echo($trainingsFeedbacks->updateQuestion($_GET['id'],$_GET['field'],$_GET['val']));
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($trainingsFeedbacks->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['protocol'])));
		break;
		case 'sendDetails':
			echo($trainingsFeedbacks->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>