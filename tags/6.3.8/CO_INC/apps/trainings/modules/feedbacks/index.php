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


// get dependend module phases
//include_once(CO_INC . "/apps/trainings/modules/phases/config.php");
//include_once(CO_INC . "/apps/trainings/modules/phases/model.php");
//include_once(CO_INC . "/apps/trainings/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/trainings/modules/documents/config.php");
include_once(CO_INC . "/apps/trainings/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/trainings/modules/documents/model.php");
include_once(CO_INC . "/apps/trainings/modules/documents/controller.php");


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
		case 'getDetailsTotals':
			echo($trainingsFeedbacks->getDetailsTotals($_GET['id']));
		break;
		case 'createNew':
			echo($trainingsFeedbacks->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($trainingsFeedbacks->createDuplicate($_GET['id']));
		break;
		case 'binFeedback':
			echo($trainingsFeedbacks->binFeedback($_GET['id']));
		break;
		case 'restoreFeedback':
			echo($trainingsFeedbacks->restoreFeedback($_GET['id']));
		break;
			case 'deleteFeedback':
			echo($trainingsFeedbacks->deleteFeedback($_GET['id']));
		break;
		case 'setOrder':
			echo($trainings->setSortOrder("trainings-feedbacks-sort",$_GET['feedbackItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainingsFeedbacks->printDetails($_GET['id'],$t));
		break;
		case 'printDetailsTotals':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainingsFeedbacks->printDetailsTotals($_GET['id'],$t));
		break;
		case 'getSend':
			echo($trainingsFeedbacks->getSend($_GET['id']));
		break;
		case 'getSendTotals':
			echo($trainingsFeedbacks->getSendTotals($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($trainingsFeedbacks->getSendtoDetails("trainings_feedbacks",$_GET['id']));
		break;
		case 'getSendtoDetailsTotals':
			echo($trainingsFeedbacks->getSendtoDetailsTotals("trainings_feedbacks",$_GET['id']));
		break;
		case 'checkinFeedback':
			echo($trainingsFeedbacks->checkinFeedback($_GET['id']));
		break;
		case 'toggleIntern':
			echo($trainingsFeedbacks->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($trainingsFeedbacks->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($trainingsFeedbacks->deleteTask($_GET['id']));
		break;
		case 'restoreFeedbackTask':
			echo($trainingsFeedbacks->restoreFeedbackTask($_GET['id']));
		break;
			case 'deleteFeedbackTask':
			echo($trainingsFeedbacks->deleteFeedbackTask($_GET['id']));
		break;
		case 'getFeedbackStatusDialog':
			echo($trainingsFeedbacks->getFeedbackStatusDialog());
		break;
		case 'getFeedbackCatDialog':
			echo($trainingsFeedbacks->getFeedbackCatDialog($_GET['field'],$_GET['title']));
		break;
		case 'changeCat':
			echo($trainingsFeedbacks->changeCat($_GET['id'],$_GET['cat']));
		break;
		case 'getHelp':
			echo($trainingsFeedbacks->getHelp());
		break;
		case 'newCheckpoint':
			echo($trainingsFeedbacks->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($trainingsFeedbacks->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($trainingsFeedbacks->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($trainingsFeedbacks->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'updateQuestion':
			echo($trainingsFeedbacks->updateQuestion($_GET['id'],$_GET['field'],$_GET['val']));
		break;
		case 'updateTaskQuestion':
			echo($trainingsFeedbacks->updateTaskQuestion($_GET['id'],$_GET['val']));
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
		case 'sendDetailsTotals':
			echo($trainingsFeedbacks->sendDetailsTotals($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($trainingsFeedbacks->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>