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

foreach($evals->modules as $module  => $value) {
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
			echo($evals->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($evals->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($evals->setSortOrder("evals-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($evals->getFolderNew());
		break;
		case 'newFolder':
			echo($evals->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evals->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($evals->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($evals->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($evals->deleteFolder($_GET['id']));
		break;
		case 'getEvalList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($evals->getEvalList($_GET['id'],$sort));
		break;
		case 'setEvalOrder':
			echo($evals->setSortOrder("evals-sort",$_GET['evalItem'],$_GET['id']));
		break;
		case 'getEvalDetails':
			echo($evals->getEvalDetails($_GET['id'],$controller->applications));
		break;
		case 'printEvalDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evals->printEvalDetails($_GET['id'],$t,$controller->applications));
		break;
		case 'printEvalHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evals->printEvalHandbook($_GET['id'],$t,$controller->applications));
		break;
		case 'checkinEval':
			echo($evals->checkinEval($_GET['id']));
		break;
		case 'getEvalSend':
			echo($evals->getEvalSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($evals->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($evals->getSendtoDetails("evals",$_GET['id']));
		break;
		case 'newEval':
			echo($evals->newEval($_GET['id'],$_GET['cid']));
		break;
		case 'createDuplicate':
			echo($evals->createDuplicate($_GET['id']));
		break;
		case 'binEval':
			echo($evals->binEval($_GET['id']));
		break;
		case 'restoreEval':
			echo($evals->restoreEval($_GET['id']));
		break;
		case 'deleteEval':
			echo($evals->deleteEval($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsImportDialog':
			echo($contacts->getContactsImportDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getEvalFolderDialog':
			echo($evals->getEvalFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getEvalStatusDialog':
			echo($evals->getEvalStatusDialog());
		break;
		case 'getEvalDialog':
			echo($evals->getEvalDialog($_GET['field'],$_GET['sql']));
		break;
		case 'getEvalMoreDialog':
			echo($evals->getEvalMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getEvalCatDialog':
			echo($evals->getEvalCatDialog($_GET['field'],$_GET['title']));
		break;
		case 'getEvalCatMoreDialog':
			echo($evals->getEvalCatMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getAccessDialog':
			echo($evals->getAccessDialog());
		break;
		case 'getEvalsFoldersHelp':
			echo($evals->getEvalsFoldersHelp());
		break;
		case 'getEvalsHelp':
			echo($evals->getEvalsHelp());
		break;
		case 'getBin':
			echo($evals->getBin());
		break;
		case 'emptyBin':
			echo($evals->emptyBin());
		break;
		case 'getNavModulesNumItems':
			echo($evals->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($evals->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($evals->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($evals->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($evals->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getEvalsSearch':
			echo($evals->getEvalsSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedEvals':
			echo($evals->saveLastUsedEvals($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($evals->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($evals->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['evalstatus']));
		break;
		case 'setEvalDetails':
			echo($evals->setEvalDetails($_POST['id'], $_POST['startdate'], $_POST['enddate'], $system->checkMagicQuotes($_POST['protocol']), $system->checkMagicQuotes($_POST['protocol2']), $system->checkMagicQuotes($_POST['protocol3']), $system->checkMagicQuotes($_POST['protocol4']), $system->checkMagicQuotes($_POST['protocol5']), $system->checkMagicQuotes($_POST['protocol6']), $_POST['folder'], $_POST['number'], $_POST['kind'], $_POST['area'], $_POST['department'], $_POST['dob'], $_POST['coo'], $_POST['family'], $_POST['languages'], $_POST['languages_foreign'], $_POST['street_private'], $_POST['city_private'], $_POST['zip_private'], $_POST['phone_private'], $_POST['email_private'], $_POST['education']));
		break;
		case 'moveEval':
			echo($evals->moveEval($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendEvalDetails':
			echo($evals->sendEvalDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body']),$controller->applications));
		break;
		case 'sendFolderDetails':
			echo($evals->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($evals->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}
?>