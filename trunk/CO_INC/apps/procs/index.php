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

foreach($procs->modules as $module  => $value) {
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
			echo($procs->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($procs->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($procs->setSortOrder("procs-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($procs->getFolderNew());
		break;
		case 'newFolder':
			echo($procs->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procs->printFolderDetails($_GET['id'],$t));
		break;
		case 'getFolderSend':
			echo($procs->getFolderSend($_GET['id']));
		break;
		case 'binFolder':
			echo($procs->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($procs->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($procs->deleteFolder($_GET['id']));
		break;
		case 'getProcList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($procs->getProcList($_GET['id'],$sort));
		break;
		case 'setProcOrder':
			echo($procs->setSortOrder("procs-sort",$_GET['procItem'],$_GET['id']));
		break;
		case 'getProcDetails':
			echo($procs->getProcDetails($_GET['id']));
		break;
		case 'getDates':
			echo($procs->getDates($_GET['id']));
		break;
		case 'printProcDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procs->printProcDetails($_GET['id'],$t));
		break;
		case 'printProcHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procs->printProcHandbook($_GET['id'],$t));
		break;
		case 'checkinProc':
			echo($procs->checkinProc($_GET['id']));
		break;
		case 'getProcSend':
			echo($procs->getProcSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($procs->getSendtoDetails("procs",$_GET['id']));
		break;
		case 'newProc':
			echo($procs->newProc($_GET['id']));
		break;
		case 'createDuplicate':
			echo($procs->createDuplicate($_GET['id']));
		break;
		case 'binProc':
			echo($procs->binProc($_GET['id']));
		break;
		case 'restoreProc':
			echo($procs->restoreProc($_GET['id']));
		break;
		case 'deleteProc':
			echo($procs->deleteProc($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getProcFolderDialog':
			echo($procs->getProcFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getProcStatusDialog':
			echo($procs->getProcStatusDialog());
		break;
		case 'getAccessDialog':
			echo($procs->getAccessDialog());
		break;
		case 'getBin':
			echo($procs->getBin());
		break;
		case 'emptyBin':
			echo($procs->emptyBin());
		break;
		case 'newProcNote':
			echo($procs->newProcNote($_GET['id'],$_GET['x'],$_GET['y'],$_GET['z'],$_GET['what']));
		break;
		case 'binItems':
			echo($procs->binItems($_GET['id']));
		break;
		case 'deleteProcNote':
			echo($procs->deleteProcNote($_GET['id']));
		break;
		case 'saveItemStyle':
			echo($procs->saveItemStyle($_GET['id'],$_GET['shape'],$_GET['color']));
		break;
		case 'deleteItem':
			echo($procs->deleteItem($_GET['id']));
		break;
		case 'restoreItem':
			echo($procs->restoreItem($_GET['id']));
		break;
		case 'updateNotePosition':
			echo($procs->updateNotePosition($_GET['id'],$_GET['x'],$_GET['y'],$_GET['z']));
		break;
		case 'updateNoteSize':
			echo($procs->updateNoteSize($_GET['id'],$_GET['w'],$_GET['h']));
		break;
		/*case 'setProcNoteToggle':
			echo($procs->setProcNoteToggle($_GET['id'],$_GET['t']));
		break;*/
		case 'getProcsFoldersHelp':
			echo($procs->getProcsFoldersHelp());
		break;
		case 'getProcsHelp':
			echo($procs->getProcsHelp());
		break;
		case 'getWidgetAlerts':
			echo($procs->getWidgetAlerts());
		break;
		case 'markNoticeRead':
			echo($procs->markNoticeRead($_GET['pid']));
		break;
		case 'getNavModulesNumItems':
			echo($procs->getNavModulesNumItems($_GET['id']));
		break;
		case 'getProcsSearch':
			echo($procs->getProcsSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedProcs':
			echo($procs->saveLastUsedProcs($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($procs->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($procs->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['procstatus']));
		break;
		case 'sendFolderDetails':
			echo($procs->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'setProcDetails':
			echo($procs->setProcDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['folder']));
		break;
		case 'saveProcNote':
			echo($procs->saveProcNote($_POST['id'],$system->checkMagicQuotes($_POST['title']),$system->checkMagicQuotes($_POST['text'])));
		break;
		case 'moveProc':
			echo($procs->moveProc($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendProcDetails':
			echo($procs->sendProcDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>