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
		case 'getFolderDetailsList':
			echo($patients->getFolderDetailsList($_GET['id']));
		break;
		case 'getFolderDetailsInvoices':
			$view = "Timeline";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($patients->getFolderDetailsInvoices($_GET['id'],$view));
		break;
		case 'getFolderDetailsRevenue':
			echo($patients->getFolderDetailsRevenue($_GET['id']));
		break;
		case 'getFolderDetailsRevenueResults':
			echo($patients->getFolderDetailsRevenueResults($_GET['id'],$_GET['who'],$_GET['start'],$_GET['end']));
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
		case 'printFolderDetailsList':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patients->printFolderDetailsList($_GET['id'],$t));
		break;
		case 'printFolderDetailsInvoices':
			echo($patients->printFolderDetailsInvoices($_GET['id'],$_GET['view']));
		break;
		case 'printFolderDetailsRevenue':
			echo $patients->printFolderDetailsRevenue($_GET['id'],$_GET['who'],$_GET['start'],$_GET['end']);
		break;
		case 'getSendFolderDetailsList':
			echo($patients->getFolderSend($_GET['id']));
		break;
		case 'getSendFolderDetailsInvoices':
			echo($patients->getFolderSendInvoices($_GET['id'],$_GET['view']));
		break;
		case 'getSendFolderDetailsRevenue':
			echo $patients->getFolderSendRevenue($_GET['id'],$_GET['who'],$_GET['start'],$_GET['end']);
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
		case 'getPatientDialogInsuranceAdd':
			echo($patients->getPatientDialogInsuranceAdd($_GET['field']));
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
		case 'getWidgetAlerts':
			echo($patients->getWidgetAlerts());
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
		case 'getPatientsSearch':
			echo($patients->getPatientsSearch($_GET['term'],$_GET['exclude']));
		break;
		case 'saveLastUsedPatients':
			echo($patients->saveLastUsedPatients($_GET['id']));
		break;
		case 'getGlobalSearch':
			echo($patients->getGlobalSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
		case 'getInlineSearch':
			echo($patients->getInlineSearch($system->checkMagicQuotesTinyMCE($_GET['term'])));
		break;
		case 'getInsuranceContext':
			echo($patients->getInsuranceContext($_GET['id'],$_GET['field'],$_GET['edit']));
		break;
		case 'getTreatmentsDialog':
			echo($patients->getTreatmentsDialog($_GET['field'],$_GET['append']));
		break;
		case 'getTreatmentsLocationsDialog':
			echo($patients->getTreatmentsLocationsDialog($_GET['field'],$_GET['append']));
		break;
		case 'getCalendarTreatmentsSearch':
			echo($patients->getCalendarTreatmentsSearch($_GET['term']));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($patients->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['patientstatus']));
		break;
		case 'setPatientDetails':
			echo($patients->setPatientDetails($_POST['id'], $_POST['folder'], $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['number'], $_POST['insurance'], $_POST['insuranceadd'], $_POST['dob'], $_POST['coo'], $_POST['documents']));
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
		case 'sendFolderDetailsInvoices':
			echo($patients->sendFolderDetailsInvoices($_POST['variable'], $_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'sendFolderDetailsRevenue':
			echo($patients->sendFolderDetailsRevenue($_POST['variable'], $_POST['id'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($patients->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}
?>