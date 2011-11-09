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

foreach($publishers->modules as $module  => $value) {
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
			echo($publishers->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($publishers->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($publishers->setSortOrder("publishers-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($publishers->getFolderNew());
		break;
		case 'newFolder':
			echo($publishers->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($publishers->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($publishers->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($publishers->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($publishers->deleteFolder($_GET['id']));
		break;
		case 'getPublisherList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($publishers->getPublisherList($_GET['id'],$sort));
		break;
		case 'setPublisherOrder':
			echo($publishers->setSortOrder("publishers-sort",$_GET['publisherItem'],$_GET['id']));
		break;
		case 'getPublisherDetails':
			echo($publishers->getPublisherDetails($_GET['id']));
		break;
		case 'getDates':
			echo($publishers->getDates($_GET['id']));
		break;
		case 'printPublisherDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($publishers->printPublisherDetails($_GET['id'],$t));
		break;
		case 'printPublisherHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($publishers->printPublisherHandbook($_GET['id'],$t));
		break;
		case 'checkinPublisher':
			echo($publishers->checkinPublisher($_GET['id']));
		break;
		case 'getPublisherSend':
			echo($publishers->getPublisherSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($publishers->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($publishers->getSendtoDetails("publishers",$_GET['id']));
		break;
		case 'newPublisher':
			echo($publishers->newPublisher($_GET['id']));
		break;
		case 'createDuplicate':
			echo($publishers->createDuplicate($_GET['id']));
		break;
		case 'binPublisher':
			echo($publishers->binPublisher($_GET['id']));
		break;
		case 'restorePublisher':
			echo($publishers->restorePublisher($_GET['id']));
		break;
		case 'deletePublisher':
			echo($publishers->deletePublisher($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getPublisherFolderDialog':
			echo($publishers->getPublisherFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getPublisherStatusDialog':
			echo($publishers->getPublisherStatusDialog());
		break;
		case 'getAccessDialog':
			echo($publishers->getAccessDialog());
		break;
		case 'getPublishersFoldersHelp':
			echo($publishers->getPublishersFoldersHelp());
		break;
		case 'getPublishersHelp':
			echo($publishers->getPublishersHelp());
		break;
		case 'getBin':
			echo($publishers->getBin());
		break;
		case 'emptyBin':
			echo($publishers->emptyBin());
		break;

	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($publishers->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['publisherstatus']));
		break;
		case 'setPublisherDetails':
			echo($publishers->setPublisherDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['ordered_by'], $system->checkMagicQuotes($_POST['ordered_by_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['folder'], $_POST['status'], $_POST['status_date']));
		break;
		case 'movePublisher':
			echo($publishers->movePublisher($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendPublisherDetails':
			echo($publishers->sendPublisherDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($publishers->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>