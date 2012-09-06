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

foreach($patients->modules as $module  => $value) {
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
			echo($patients->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($patients->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($patients->setSortOrder("patients-folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($patients->getFolderNew());
		break;
		case 'newFolder':
			echo($patients->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patients->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($patients->binFolder($_GET['id']));
		break;
		case 'restoreFolder':
			echo($patients->restoreFolder($_GET['id']));
		break;
		case 'deleteFolder':
			echo($patients->deleteFolder($_GET['id']));
		break;
		case 'getPatientList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patients->getPatientList($_GET['id'],$sort));
		break;
		case 'setPatientOrder':
			echo($patients->setSortOrder("patients-sort",$_GET['patientItem'],$_GET['id']));
		break;
		case 'getPatientDetails':
			echo($patients->getPatientDetails($_GET['id']));
		break;
		case 'printPatientDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patients->printPatientDetails($_GET['id'],$t));
		break;
		case 'printPatientHandbook':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patients->printPatientHandbook($_GET['id'],$t));
		break;
		case 'checkinPatient':
			echo($patients->checkinPatient($_GET['id']));
		break;
		case 'getPatientSend':
			echo($patients->getPatientSend($_GET['id']));
		break;
		case 'getFolderSend':
			echo($patients->getFolderSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patients->getSendtoDetails("patients",$_GET['id']));
		break;
		case 'newPatient':
			echo($patients->newPatient($_GET['id'],$_GET['cid']));
		break;
		case 'createDuplicate':
			echo($patients->createDuplicate($_GET['id']));
		break;
		case 'binPatient':
			echo($patients->binPatient($_GET['id']));
		break;
		case 'restorePatient':
			echo($patients->restorePatient($_GET['id']));
		break;
		case 'deletePatient':
			echo($patients->deletePatient($_GET['id']));
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
		case 'getPatientFolderDialog':
			echo($patients->getPatientFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getPatientStatusDialog':
			echo($patients->getPatientStatusDialog());
		break;
		case 'getPatientDialog':
			echo($patients->getPatientDialog($_GET['field'],$_GET['sql']));
		break;
		case 'getPatientMoreDialog':
			echo($patients->getPatientMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getPatientCatDialog':
			echo($patients->getPatientCatDialog($_GET['field'],$_GET['title']));
		break;
		case 'getPatientCatMoreDialog':
			echo($patients->getPatientCatMoreDialog($_GET['field'],$_GET['title']));
		break;
		case 'getAccessDialog':
			echo($patients->getAccessDialog());
		break;
		case 'getPatientsFoldersHelp':
			echo($patients->getPatientsFoldersHelp());
		break;
		case 'getPatientsHelp':
			echo($patients->getPatientsHelp());
		break;
		case 'getBin':
			echo($patients->getBin());
		break;
		case 'emptyBin':
			echo($patients->emptyBin());
		break;
		case 'getNavModulesNumItems':
			echo($patients->getNavModulesNumItems($_GET['id']));
		break;
		case 'newCheckpoint':
			echo($patients->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($patients->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($patients->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($patients->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getGlobalSearch':
			echo($patients->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($patients->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['patientstatus']));
		break;
		case 'setPatientDetails':
			echo($patients->setPatientDetails($_POST['id'], $_POST['startdate'], $_POST['enddate'], $system->checkMagicQuotes($_POST['protocol']), $system->checkMagicQuotes($_POST['protocol2']), $system->checkMagicQuotes($_POST['protocol3']), $_POST['folder'], $_POST['number'], $_POST['kind'], $_POST['area'], $_POST['department'], $_POST['dob'], $_POST['coo'], $_POST['languages'], $_POST['street_private'], $_POST['city_private'], $_POST['zip_private'], $_POST['phone_private'], $_POST['email_private'], $_POST['education']));
		break;
		case 'movePatient':
			echo($patients->movePatient($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
		case 'sendPatientDetails':
			echo($patients->sendPatientDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetails':
			echo($patients->sendFolderDetails($_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($patients->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}
?>