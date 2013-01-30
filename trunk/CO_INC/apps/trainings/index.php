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

foreach($trainings->modules as $module  => $value) {
	include_once("modules/".$module."/config.php");
	include_once("modules/".$module."/lang/" . $session->userlang . ".php");
	include_once("modules/".$module."/model.php");
	include_once("modules/".$module."/controller.php");
}

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getFolderList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainings->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($trainings->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($trainings->setSortOrder("trainings-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($trainings->getFolderNew());
		break;
		case 'newFolder':
			echo($trainings->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainings->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($trainings->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($trainings->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($trainings->deleteFolder($_GET['id']));
		break;
		case 'getTrainingList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainings->getTrainingList($_GET['id'],$sort));
		break;
		case 'setTrainingOrder':
			echo($trainings->setSortOrder("trainings-sort",$_GET['trainingItem'],$_GET['id']));
		break;
		case 'getTrainingDetails':
			echo($trainings->getTrainingDetails($_GET['id']));
		break;
		case 'printTrainingDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainings->printTrainingDetails($_GET['id'],$t));
		break;
		case 'printTrainingHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainings->printTrainingHandbook($_GET['id'],$t));
		break;
		case 'checkinTraining':
			echo($trainings->checkinTraining($_GET['id']));
		break;
		case 'getTrainingSend':
			echo($trainings->getTrainingSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($trainings->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($trainings->getSendtoDetails("trainings",$_GET['id']));
		break;
		case 'newTraining':
			echo($trainings->newTraining($_GET['id']));
		break;
		case 'createDuplicate':
			echo($trainings->createDuplicate($_GET['id']));
		break;
		case 'binTraining':
			echo($trainings->binTraining($_GET['id']));
		break;
		case 'restoreTraining':
			echo($trainings->restoreTraining($_GET['id']));
		break;
		case 'deleteTraining':
			echo($trainings->deleteTraining($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getTrainingFolderDialog':
			echo($trainings->getTrainingFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getTrainingStatusDialog':
			echo($trainings->getTrainingStatusDialog());
		break;
		case 'getTrainingDialog':
			echo($trainings->getTrainingDialog($_GET['field'],$_GET['title']));
		break;
		case 'getTrainingMoreDialog':
			echo($trainings->getTrainingMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getTrainingCatDialog':
			echo($trainings->getTrainingCatDialog($_GET['field'],$_GET['title']));
		break;
		case 'getTrainingCatMoreDialog':
			echo($trainings->getTrainingCatMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getAccessDialog':
			echo($trainings->getAccessDialog());
		break;
		case 'getTrainingsFoldersHelp':
			echo($trainings->getTrainingsFoldersHelp());
		break;
		case 'getTrainingsHelp':
			echo($trainings->getTrainingsHelp());
		break;
		case 'getBin':
			echo($trainings->getBin());
		break;
		case 'emptyBin':
			echo($trainings->emptyBin());
		break;
		case 'getNavModulesNumItems':
			echo($trainings->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($trainings->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($trainings->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($trainings->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($trainings->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getTrainingsSearch':
			echo($trainings->getTrainingsSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedTrainings':
			echo($trainings->saveLastUsedTrainings($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($trainings->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($trainings->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['trainingstatus']));
		break;
		case 'setTrainingDetails':
			echo($trainings->setTrainingDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['ordered_by'], $system->checkMagicQuotes($_POST['ordered_by_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['folder'], $_POST['training'], $_POST['trainingmore'], $_POST['trainingcat'], $_POST['trainingcatmore'], $_POST['product'], $_POST['product_desc'], $_POST['charge'], $_POST['number']));
		break;
		case 'moveTraining':
			echo($trainings->moveTraining($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendTrainingDetails':
			echo($trainings->sendTrainingDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($trainings->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($trainings->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}
?>