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

foreach($forums->modules as $module  => $value) {
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
			echo($forums->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($forums->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($forums->setSortOrder("forums-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($forums->getFolderNew());
		break;
		case 'newFolder':
			echo($forums->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($forums->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($forums->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($forums->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($forums->deleteFolder($_GET['id']));
		break;
		case 'getForumList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($forums->getForumList($_GET['id'],$sort));
		break;
		case 'setForumOrder':
			echo($forums->setSortOrder("forums-sort",$_GET['forumItem'],$_GET['id']));
		break;
		case 'getForumDetails':
			echo($forums->getForumDetails($_GET['id']));
		break;
		case 'getDates':
			echo($forums->getDates($_GET['id']));
		break;
		case 'printForumDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($forums->printForumDetails($_GET['id'],$t));
		break;
		case 'checkinForum':
			echo($forums->checkinForum($_GET['id']));
		break;
		case 'getForumSend':
			echo($forums->getForumSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($forums->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($forums->getSendtoDetails("forums",$_GET['id']));
		break;
		case 'newForum':
			echo($forums->newForum($_GET['id']));
		break;
		case 'createDuplicate':
			echo($forums->createDuplicate($_GET['id']));
		break;
		case 'binForum':
			echo($forums->binForum($_GET['id']));
		break;
		case 'restoreForum':
			echo($forums->restoreForum($_GET['id']));
		break;
		case 'deleteForum':
			echo($forums->deleteForum($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getForumFolderDialog':
			echo($forums->getForumFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getForumStatusDialog':
			echo($forums->getForumStatusDialog());
		break;
		case 'getAccessDialog':
			echo($forums->getAccessDialog());
		break;
		case 'getForumsFoldersHelp':
			echo($forums->getForumsFoldersHelp());
		break;
		case 'getForumsHelp':
			echo($forums->getForumsHelp());
		break;
		case 'getBin':
			echo($forums->getBin());
		break;
		case 'emptyBin':
			echo($forums->emptyBin());
		break;
		case 'setItemStatus':
			echo($forums->setItemStatus($_GET['id'],$_GET["status"]));
		break;
		case 'binForumItem':
			echo($forums->binForumItem($_GET['id']));
		break;
		case 'deleteItem':
			echo($forums->deleteItem($_GET['id']));
		break;
		case 'restoreItem':
			echo($forums->restoreItem($_GET['id']));
		break;
		case 'getWidgetAlerts':
			echo($forums->getWidgetAlerts());
		break;
		case 'markNoticeRead':
			echo($forums->markNoticeRead($_GET['pid']));
		break;
		case 'markNewPostRead':
			echo($forums->markNewPostRead($_GET['pid']));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($forums->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['forumstatus']));
		break;
		case 'setForumDetails':
			echo($forums->setForumDetails($_POST['id'], $_POST['folder'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']), $_POST['status'], $_POST['forumsstatus_date']));
		break;
		case 'moveForum':
			echo($forums->moveForum($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendForumDetails':
			echo($forums->sendForumDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($forums->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'addForumItem':
			echo($forums->addForumItem($_POST['id'], $system->checkMagicQuotesTinyMCE($_POST['text']), $_POST['replyid'] , $_POST['num']));
		break;
	}
}
?>