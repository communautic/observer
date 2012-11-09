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

foreach($complaints->modules as $module  => $value) {
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
			echo($complaints->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($complaints->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($complaints->setSortOrder("complaints-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($complaints->getFolderNew());
		break;
		case 'newFolder':
			echo($complaints->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($complaints->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($complaints->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($complaints->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($complaints->deleteFolder($_GET['id']));
		break;
		case 'getComplaintList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($complaints->getComplaintList($_GET['id'],$sort));
		break;
		case 'setComplaintOrder':
			echo($complaints->setSortOrder("complaints-sort",$_GET['complaintItem'],$_GET['id']));
		break;
		case 'getComplaintDetails':
			echo($complaints->getComplaintDetails($_GET['id']));
		break;
		case 'printComplaintDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($complaints->printComplaintDetails($_GET['id'],$t));
		break;
		case 'printComplaintHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($complaints->printComplaintHandbook($_GET['id'],$t));
		break;
		case 'checkinComplaint':
			echo($complaints->checkinComplaint($_GET['id']));
		break;
		case 'getComplaintSend':
			echo($complaints->getComplaintSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($complaints->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($complaints->getSendtoDetails("complaints",$_GET['id']));
		break;
		case 'newComplaint':
			echo($complaints->newComplaint($_GET['id']));
		break;
		case 'createDuplicate':
			echo($complaints->createDuplicate($_GET['id']));
		break;
		case 'binComplaint':
			echo($complaints->binComplaint($_GET['id']));
		break;
		case 'restoreComplaint':
			echo($complaints->restoreComplaint($_GET['id']));
		break;
		case 'deleteComplaint':
			echo($complaints->deleteComplaint($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getComplaintFolderDialog':
			echo($complaints->getComplaintFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getComplaintStatusDialog':
			echo($complaints->getComplaintStatusDialog());
		break;
		case 'getComplaintDialog':
			echo($complaints->getComplaintDialog($_GET['field'],$_GET['title']));
		break;
		case 'getComplaintMoreDialog':
			echo($complaints->getComplaintMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getComplaintCatDialog':
			echo($complaints->getComplaintCatDialog($_GET['field'],$_GET['title']));
		break;
		case 'getComplaintCatMoreDialog':
			echo($complaints->getComplaintCatMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getAccessDialog':
			echo($complaints->getAccessDialog());
		break;
		case 'getComplaintsFoldersHelp':
			echo($complaints->getComplaintsFoldersHelp());
		break;
		case 'getComplaintsHelp':
			echo($complaints->getComplaintsHelp());
		break;
		case 'getBin':
			echo($complaints->getBin());
		break;
		case 'emptyBin':
			echo($complaints->emptyBin());
		break;
		case 'getNavModulesNumItems':
			echo($complaints->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($complaints->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($complaints->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($complaints->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($complaints->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getGlobalSearch':
			echo($complaints->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($complaints->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['complaintstatus']));
		break;
		case 'setComplaintDetails':
			echo($complaints->setComplaintDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['ordered_by'], $system->checkMagicQuotes($_POST['ordered_by_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['folder'], $_POST['complaint'], $_POST['complaintmore'], $_POST['complaintcat'], $_POST['complaintcatmore'], $_POST['product'], $_POST['product_desc'], $_POST['charge'], $_POST['number']));
		break;
		case 'moveComplaint':
			echo($complaints->moveComplaint($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendComplaintDetails':
			echo($complaints->sendComplaintDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($complaints->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($complaints->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}
?>