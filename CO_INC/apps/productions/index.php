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

foreach($productions->modules as $module  => $value) {
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
			echo($productions->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($productions->getFolderDetails($_GET['id']));
		break;
		case 'getFolderDetailsList':
			echo($productions->getFolderDetailsList($_GET['id']));
		break;
		case 'getFolderDetailsMultiView':
			$zoom = 0;
			if(!empty($_GET['zoom'])) {
				$zoom = $_GET['zoom'];
			}
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($productions->getFolderDetailsMultiView($_GET['id'],$view,$zoom));
		break;
		case 'getFolderDetailsStatus':
			echo($productions->getFolderDetailsStatus($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($productions->setSortOrder("productions-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($productions->getFolderNew());
		break;
		case 'newFolder':
			echo($productions->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productions->printFolderDetails($_GET['id'],$t));
		break;
		case 'printFolderDetailsList':
			echo($productions->printFolderDetailsList($_GET['id']));
		break;
		case 'printFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($productions->printFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'printFolderDetailsStatus':
			echo($productions->printFolderDetailsList($_GET['id']));
		break;
		case 'binFolder':
			echo($productions->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($productions->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($productions->deleteFolder($_GET['id']));
		break;
		case 'getProductionList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($productions->getProductionList($_GET['id'],$sort));
		break;
		case 'setProductionOrder':
			echo($productions->setSortOrder("productions-sort",$_GET['productionItem'],$_GET['id']));
		break;
		case 'getProductionDetails':
			echo($productions->getProductionDetails($_GET['id']));
		break;
		case 'getDates':
			echo($productions->getDates($_GET['id']));
		break;
		case 'printProductionDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productions->printProductionDetails($_GET['id'],$t));
		break;
		case 'printProductionHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productions->printProductionHandbook($_GET['id'],$t));
		break;
		case 'checkinProduction':
			echo($productions->checkinProduction($_GET['id']));
		break;
		case 'getProductionSend':
			echo($productions->getProductionSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($productions->getFolderSend($_GET['id']));
		break;
		case 'getSendFolderDetailsList':
			echo($productions->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($productions->getSendFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'getSendFolderDetailsStatus':
			echo($productions->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($productions->getSendtoDetails("productions",$_GET['id']));
		break;
		case 'newProduction':
			echo($productions->newProduction($_GET['id']));
		break;
		case 'createDuplicate':
			echo($productions->createDuplicate($_GET['id']));
		break;
		case 'binProduction':
			echo($productions->binProduction($_GET['id']));
		break;
		case 'restoreProduction':
			echo($productions->restoreProduction($_GET['id']));
		break;
		case 'deleteProduction':
			echo($productions->deleteProduction($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getProductionFolderDialog':
			echo($productions->getProductionFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getProductionStatusDialog':
			echo($productions->getProductionStatusDialog());
		break;
		case 'getAccessDialog':
			echo($productions->getAccessDialog());
		break;
		case 'getProductionsFoldersHelp':
			echo($productions->getProductionsFoldersHelp());
		break;
		case 'getProductionsHelp':
			echo($productions->getProductionsHelp());
		break;
		case 'getBin':
			echo($productions->getBin());
		break;
		case 'emptyBin':
			echo($productions->emptyBin());
		break;
		case 'getWidgetAlerts':
			echo($productions->getWidgetAlerts());
		break;
		case 'markNoticeRead':
			echo($productions->markNoticeRead($_GET['pid']));
		break;
		case 'getNavModulesNumItems':
			echo($productions->getNavModulesNumItems($_GET['id']));
		break;
		case 'getSearch':
			echo($productions->getSearch($system->checkMagicQuotesTinyMCE($_GET['string'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($productions->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['productionstatus']));
		break;
		case 'setProductionDetails':
			echo($productions->setProductionDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['ordered_by'], $system->checkMagicQuotes($_POST['ordered_by_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['folder'], $_POST['status'], $_POST['status_date']));
		break;
		case 'moveProduction':
			echo($productions->moveProduction($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendProductionDetails':
			echo($productions->sendProductionDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($productions->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsList':
			echo($productions->sendFolderDetailsList($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsMultiView':
			echo($productions->sendFolderDetailsMultiView($_POST['variable'], $_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>