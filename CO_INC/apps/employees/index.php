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

foreach($employees->modules as $module  => $value) {
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
			echo($employees->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($employees->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($employees->setSortOrder("employees-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($employees->getFolderNew());
		break;
		case 'newFolder':
			echo($employees->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employees->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($employees->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($employees->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($employees->deleteFolder($_GET['id']));
		break;
		case 'getEmployeeList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($employees->getEmployeeList($_GET['id'],$sort));
		break;
		case 'setEmployeeOrder':
			echo($employees->setSortOrder("employees-sort",$_GET['employeeItem'],$_GET['id']));
		break;
		case 'getEmployeeDetails':
			echo($employees->getEmployeeDetails($_GET['id']));
		break;
		case 'printEmployeeDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employees->printEmployeeDetails($_GET['id'],$t));
		break;
		case 'printEmployeeHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employees->printEmployeeHandbook($_GET['id'],$t));
		break;
		case 'checkinEmployee':
			echo($employees->checkinEmployee($_GET['id']));
		break;
		case 'getEmployeeSend':
			echo($employees->getEmployeeSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($employees->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($employees->getSendtoDetails("employees",$_GET['id']));
		break;
		case 'newEmployee':
			echo($employees->newEmployee($_GET['id'],$_GET['cid']));
		break;
		case 'createDuplicate':
			echo($employees->createDuplicate($_GET['id']));
		break;
		case 'binEmployee':
			echo($employees->binEmployee($_GET['id']));
		break;
		case 'restoreEmployee':
			echo($employees->restoreEmployee($_GET['id']));
		break;
		case 'deleteEmployee':
			echo($employees->deleteEmployee($_GET['id']));
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
		case 'getEmployeeFolderDialog':
			echo($employees->getEmployeeFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getEmployeeStatusDialog':
			echo($employees->getEmployeeStatusDialog());
		break;
		case 'getEmployeeDialog':
			echo($employees->getEmployeeDialog($_GET['field'],$_GET['sql']));
		break;
		case 'getEmployeeMoreDialog':
			echo($employees->getEmployeeMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getEmployeeCatDialog':
			echo($employees->getEmployeeCatDialog($_GET['field'],$_GET['title']));
		break;
		case 'getEmployeeCatMoreDialog':
			echo($employees->getEmployeeCatMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getAccessDialog':
			echo($employees->getAccessDialog());
		break;
		case 'getEmployeesFoldersHelp':
			echo($employees->getEmployeesFoldersHelp());
		break;
		case 'getEmployeesHelp':
			echo($employees->getEmployeesHelp());
		break;
		case 'getBin':
			echo($employees->getBin());
		break;
		case 'emptyBin':
			echo($employees->emptyBin());
		break;
		case 'getNavModulesNumItems':
			echo($employees->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($employees->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($employees->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($employees->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($employees->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getGlobalSearch':
			echo($employees->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($employees->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['employeestatus']));
		break;
		case 'setEmployeeDetails':
			echo($employees->setEmployeeDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['enddate'], $system->checkMagicQuotes($_POST['protocol']), $system->checkMagicQuotes($_POST['protocol2']), $system->checkMagicQuotes($_POST['protocol3']), $_POST['folder'], $_POST['number'], $_POST['kind'], $_POST['area'], $_POST['department'], $_POST['dob'], $_POST['coo'], $_POST['languages'], $_POST['street_private'], $_POST['city_private'], $_POST['zip_private'], $_POST['phone_private'], $_POST['email_private'], $_POST['education']));
		break;
		case 'moveEmployee':
			echo($employees->moveEmployee($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendEmployeeDetails':
			echo($employees->sendEmployeeDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($employees->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($employees->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}
?>