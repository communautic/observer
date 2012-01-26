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

foreach($brainstorms->modules as $module  => $value) {
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
			echo($brainstorms->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($brainstorms->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($brainstorms->setSortOrder("brainstorms-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($brainstorms->getFolderNew());
		break;
		case 'newFolder':
			echo($brainstorms->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstorms->printFolderDetails($_GET['id'],$t));
		break;
		case 'getFolderSend':
			echo($brainstorms->getFolderSend($_GET['id']));
		break;
		case 'binFolder':
			echo($brainstorms->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($brainstorms->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($brainstorms->deleteFolder($_GET['id']));
		break;
		case 'getBrainstormList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($brainstorms->getBrainstormList($_GET['id'],$sort));
		break;
		case 'setBrainstormOrder':
			echo($brainstorms->setSortOrder("brainstorms-sort",$_GET['brainstormItem'],$_GET['id']));
		break;
		case 'getBrainstormDetails':
			echo($brainstorms->getBrainstormDetails($_GET['id']));
		break;
		case 'getDates':
			echo($brainstorms->getDates($_GET['id']));
		break;
		case 'printBrainstormDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstorms->printBrainstormDetails($_GET['id'],$t));
		break;
		case 'printBrainstormHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstorms->printBrainstormHandbook($_GET['id'],$t));
		break;
		case 'checkinBrainstorm':
			echo($brainstorms->checkinBrainstorm($_GET['id']));
		break;
		case 'getBrainstormSend':
			echo($brainstorms->getBrainstormSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($brainstorms->getSendtoDetails("brainstorms",$_GET['id']));
		break;
		case 'newBrainstorm':
			echo($brainstorms->newBrainstorm($_GET['id']));
		break;
		case 'createDuplicate':
			echo($brainstorms->createDuplicate($_GET['id']));
		break;
		case 'binBrainstorm':
			echo($brainstorms->binBrainstorm($_GET['id']));
		break;
		case 'restoreBrainstorm':
			echo($brainstorms->restoreBrainstorm($_GET['id']));
		break;
		case 'deleteBrainstorm':
			echo($brainstorms->deleteBrainstorm($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getBrainstormFolderDialog':
			echo($brainstorms->getBrainstormFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getBrainstormStatusDialog':
			echo($brainstorms->getBrainstormStatusDialog());
		break;
		case 'getAccessDialog':
			echo($brainstorms->getAccessDialog());
		break;
		case 'getBin':
			echo($brainstorms->getBin());
		break;
		case 'emptyBin':
			echo($brainstorms->emptyBin());
		break;
		case 'newBrainstormNote':
			echo($brainstorms->newBrainstormNote($_GET['id'],$_GET['z']));
		break;
		case 'binBrainstormNote':
			echo($brainstorms->binBrainstormNote($_GET['id']));
		break;
		case 'deleteItem':
			echo($brainstorms->deleteItem($_GET['id']));
		break;
		case 'restoreItem':
			echo($brainstorms->restoreItem($_GET['id']));
		break;
		case 'updateNotePosition':
			echo($brainstorms->updateNotePosition($_GET['id'],$_GET['x'],$_GET['y'],$_GET['z']));
		break;
		case 'updateNoteSize':
			echo($brainstorms->updateNoteSize($_GET['id'],$_GET['w'],$_GET['h']));
		break;
		case 'setBrainstormNoteToggle':
			echo($brainstorms->setBrainstormNoteToggle($_GET['id'],$_GET['t']));
		break;
		case 'getBrainstormsFoldersHelp':
			echo($brainstorms->getBrainstormsFoldersHelp());
		break;
		case 'getBrainstormsHelp':
			echo($brainstorms->getBrainstormsHelp());
		break;
		case 'getWidgetAlerts':
			echo($brainstorms->getWidgetAlerts());
		break;
		case 'markNoticeRead':
			echo($brainstorms->markNoticeRead($_GET['pid']));
		break;
		case 'getNavModulesNumItems':
			echo($brainstorms->getNavModulesNumItems($_GET['id']));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($brainstorms->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['brainstormstatus']));
		break;
		case 'sendFolderDetails':
			echo($brainstorms->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'setBrainstormDetails':
			echo($brainstorms->setBrainstormDetails($_POST['id'], $system->checkMagicQuotes($_POST['title'])));
		break;
		case 'saveBrainstormNote':
			echo($brainstorms->saveBrainstormNote($_POST['id'],$system->checkMagicQuotes($_POST['title']),$system->checkMagicQuotes($_POST['text'])));
		break;
		case 'moveBrainstorm':
			echo($brainstorms->moveBrainstorm($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendBrainstormDetails':
			echo($brainstorms->sendBrainstormDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>