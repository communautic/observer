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
					
// get dependend module documents
include_once(CO_INC . "/apps/patients/modules/documents/config.php");
include_once(CO_INC . "/apps/patients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/documents/model.php");
include_once(CO_INC . "/apps/patients/modules/documents/controller.php");


// Reports
include_once(CO_INC . "/apps/patients/modules/reports/config.php");
include_once(CO_INC . "/apps/patients/modules/reports/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/reports/model.php");
include_once(CO_INC . "/apps/patients/modules/reports/controller.php");
$patientsReports = new PatientsReports("reports");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsReports->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsReports->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($patientsReports->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($patientsReports->createDuplicate($_GET['id']));
		break;
		case 'binReport':
			echo($patientsReports->binReport($_GET['id']));
		break;
		case 'restoreReport':
			echo($patientsReports->restoreReport($_GET['id']));
		break;
			case 'deleteReport':
			echo($patientsReports->deleteReport($_GET['id']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-reports-sort",$_GET['reportItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsReports->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($patientsReports->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patientsReports->getSendtoDetails("patients_reports",$_GET['id']));
		break;
		case 'checkinReport':
			echo($patientsReports->checkinReport($_GET['id']));
		break;
		case 'toggleIntern':
			echo($patientsReports->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getReportStatusDialog':
			echo($patientsReports->getReportStatusDialog());
		break;
		case 'getHelp':
			echo($patientsReports->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($patientsReports->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['reportstart'], $_POST['reportend'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['report_access'],$_POST['report_access_orig'],$_POST['report_status'],$_POST['report_status_date']));
		break;
		case 'sendDetails':
			echo($patientsReports->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>