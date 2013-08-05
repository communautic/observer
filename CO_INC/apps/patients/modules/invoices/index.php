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
// Treatments
include_once(CO_INC . "/apps/patients/modules/treatments/config.php");
include_once(CO_INC . "/apps/patients/modules/treatments/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/treatments/model.php");
include_once(CO_INC . "/apps/patients/modules/treatments/controller.php");
$patientsTreatments = new PatientsTreatments("treatments");

// Invoices
include_once(CO_INC . "/apps/patients/modules/invoices/config.php");
include_once(CO_INC . "/apps/patients/modules/invoices/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/invoices/model.php");
include_once(CO_INC . "/apps/patients/modules/invoices/controller.php");
$patientsInvoices = new PatientsInvoices("invoices");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsInvoices->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsInvoices->getDetails($_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsInvoices->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($patientsInvoices->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patientsInvoices->getSendtoDetails("patients_invoices",$_GET['id']));
		break;
		case 'getHelp':
			echo($patientsInvoices->getHelp());
		break;
		case 'updateQuestion':
			echo($patientsInvoices->updateQuestion($_GET['id'],$_GET['field'],$_GET['val']));
		break;
		case 'getPrintOptions':
			echo($patientsInvoices->getPrintOptions());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($patientsInvoices->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['protocol'])));
		break;
		case 'sendDetails':
			echo($patientsInvoices->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>