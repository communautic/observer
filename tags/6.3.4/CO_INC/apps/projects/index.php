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

foreach($projects->modules as $module  => $value) {
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
			echo($projects->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($projects->getFolderDetails($_GET['id']));
		break;
		case 'getFolderDetailsList':
			echo($projects->getFolderDetailsList($_GET['id']));
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
			echo($projects->getFolderDetailsMultiView($_GET['id'],$view,$zoom));
		break;
		case 'getFolderDetailsStatus':
			echo($projects->getFolderDetailsStatus($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($projects->setSortOrder("projects-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($projects->getFolderNew());
		break;
		case 'newFolder':
			echo($projects->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projects->printFolderDetails($_GET['id'],$t));
		break;
		case 'printFolderDetailsList':
			echo($projects->printFolderDetailsList($_GET['id']));
		break;
		case 'printFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($projects->printFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'printFolderDetailsStatus':
			echo($projects->printFolderDetailsList($_GET['id']));
		break;
		case 'binFolder':
			echo($projects->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($projects->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($projects->deleteFolder($_GET['id']));
		break;
		case 'getProjectList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projects->getProjectList($_GET['id'],$sort));
		break;
		case 'setProjectOrder':
			echo($projects->setSortOrder("projects-sort",$_GET['projectItem'],$_GET['id']));
		break;
		case 'getProjectDetails':
			echo($projects->getProjectDetails($_GET['id']));
		break;
		case 'getDates':
			echo($projects->getDates($_GET['id']));
		break;
		case 'printProjectDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projects->printProjectDetails($_GET['id'],$t));
		break;
		case 'printProjectHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projects->printProjectHandbook($_GET['id'],$t));
		break;
		case 'checkinProject':
			echo($projects->checkinProject($_GET['id']));
		break;
		case 'getProjectSend':
			echo($projects->getProjectSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($projects->getFolderSend($_GET['id']));
		break;
		case 'getSendFolderDetailsList':
			echo($projects->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendFolderDetailsMultiView':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($projects->getSendFolderDetailsMultiView($_GET['id'],$view));
		break;
		case 'getSendFolderDetailsStatus':
			echo($projects->getSendFolderDetailsList($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($projects->getSendtoDetails("projects",$_GET['id']));
		break;
		case 'newProject':
			echo($projects->newProject($_GET['id']));
		break;
		case 'createDuplicate':
			echo($projects->createDuplicate($_GET['id']));
		break;
		case 'binProject':
			echo($projects->binProject($_GET['id']));
		break;
		case 'restoreProject':
			echo($projects->restoreProject($_GET['id']));
		break;
		case 'deleteProject':
			echo($projects->deleteProject($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getProjectFolderDialog':
			echo($projects->getProjectFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getProjectStatusDialog':
			echo($projects->getProjectStatusDialog());
		break;
		case 'getAccessDialog':
			echo($projects->getAccessDialog());
		break;
		case 'getProjectsFoldersHelp':
			echo($projects->getProjectsFoldersHelp());
		break;
		case 'getProjectsHelp':
			echo($projects->getProjectsHelp());
		break;
		case 'getBin':
			echo($projects->getBin());
		break;
		case 'emptyBin':
			echo($projects->emptyBin());
		break;
		case 'getWidgetAlerts':
			echo($projects->getWidgetAlerts());
		break;
		case 'markNoticeRead':
			echo($projects->markNoticeRead($_GET['pid']));
		break;
		case 'markNoticeDelete':
			echo($projects->markNoticeDelete($_GET['id']));
		break;
		case 'getNavModulesNumItems':
			echo($projects->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($projects->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($projects->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($projects->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($projects->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getProjectsSearch':
			echo($projects->getProjectsSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedProjects':
			echo($projects->saveLastUsedProjects($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($projects->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($projects->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['projectstatus']));
		break;
		case 'setProjectDetails':
			echo($projects->setProjectDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['ordered_by'], $system->checkMagicQuotes($_POST['ordered_by_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['folder']));
		break;
		case 'moveProject':
			echo($projects->moveProject($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendProjectDetails':
			echo($projects->sendProjectDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($projects->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsList':
			echo($projects->sendFolderDetailsList($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsMultiView':
			echo($projects->sendFolderDetailsMultiView($_POST['variable'], $_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>