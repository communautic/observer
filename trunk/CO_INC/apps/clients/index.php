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

foreach($clients->modules as $module  => $value) {
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
			echo($clients->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($clients->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($clients->setSortOrder("clients-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($clients->getFolderNew());
		break;
		case 'newFolder':
			echo($clients->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($clients->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($clients->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($clients->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($clients->deleteFolder($_GET['id']));
		break;
		case 'getClientList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($clients->getClientList($_GET['id'],$sort));
		break;
		case 'setClientOrder':
			echo($clients->setSortOrder("clients-sort",$_GET['clientItem'],$_GET['id']));
		break;
		case 'getClientDetails':
			echo($clients->getClientDetails($_GET['id']));
		break;
		case 'printClientDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($clients->printClientDetails($_GET['id'],$t));
		break;
		case 'printClientHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($clients->printClientHandbook($_GET['id'],$t));
		break;
		case 'checkinClient':
			echo($clients->checkinClient($_GET['id']));
		break;
		case 'getClientSend':
			echo($clients->getClientSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($clients->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($clients->getSendtoDetails("clients",$_GET['id']));
		break;
		case 'newClient':
			echo($clients->newClient($_GET['id']));
		break;
		case 'createDuplicate':
			echo($clients->createDuplicate($_GET['id']));
		break;
		case 'binClient':
			echo($clients->binClient($_GET['id']));
		break;
		case 'restoreClient':
			echo($clients->restoreClient($_GET['id']));
		break;
		case 'deleteClient':
			echo($clients->deleteClient($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getClientFolderDialog':
			echo($clients->getClientFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getClientStatusDialog':
			echo($clients->getClientStatusDialog());
		break;
		case 'getClientContractDialog':
			echo($clients->getClientContractDialog());
		break;
		case 'generateAccess':
			echo($clients->generateAccess($_GET['id'],$_GET['cid']));
		break;
		case 'removeAccess':
			echo($clients->removeAccess($_GET['id'],$_GET['cid']));
		break;
		case 'getAccessOrdersDialog':
			echo($clients->getAccessOrdersDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getAccessDialog':
			echo($clients->getAccessDialog());
		break;
		case 'getClientsFoldersHelp':
			echo($clients->getClientsFoldersHelp());
		break;
		case 'getClientsHelp':
			echo($clients->getClientsHelp());
		break;
		case 'getBin':
			echo($clients->getBin());
		break;
		case 'emptyBin':
			echo($clients->emptyBin());
		break;
		case 'getExportWindow':
			echo($clients->getExportWindow($_GET['id']));
		break;
		case 'getNavModulesNumItems':
			echo($clients->getNavModulesNumItems($_GET['id']));
		break;
		case 'getClientsSearch':
			echo($clients->getClientsSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedClients':
			echo($clients->saveLastUsedClients($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($clients->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($clients->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['clientstatus']));
		break;
		case 'setClientDetails':
			echo($clients->setClientDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $_POST['address'], $system->checkMagicQuotes($_POST['address_ct']), $_POST['billingaddress'], $system->checkMagicQuotes($_POST['billingaddress_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['folder'], $_POST['contract']));
		break;
		case 'moveClient':
			echo($clients->moveClient($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendClientDetails':
			echo($clients->sendClientDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($clients->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>