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

// get dependend module documents
include_once(CO_INC . "/apps/patients/modules/documents/config.php");
include_once(CO_INC . "/apps/patients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/documents/model.php");
include_once(CO_INC . "/apps/patients/modules/documents/controller.php");


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
			echo($patientsInvoices->printDetails($_GET['id'],$t,$_GET['option']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-invoices-sort",$_GET['invoiceItem'],$_GET['id']));
		break;
		case 'getSend':
			echo($patientsInvoices->getSend($_GET['id'],$_GET['option']));
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
		case 'getSendToOptions':
			echo($patientsInvoices->getSendToOptions());
		break;
		case 'newCheckpoint':
			echo($patientsInvoices->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($patientsInvoices->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($patientsInvoices->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($patientsInvoices->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getPaymentTypeDialog':
			echo($patientsInvoices->getPaymentTypeDialog($_GET['field']));
		break;
		case 'setBar':
			echo($patientsInvoices->setBar($_GET['id']));
		break;
		case 'removeBar':
			echo($patientsInvoices->removeBar($_GET['id']));
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($patientsInvoices->setDetails($_POST['pid'], $_POST['id'], $_POST['invoice_carrier'], $_POST['invoice_date'], $_POST['invoice_date_sent'], $_POST['invoiceaddress'], $_POST['payment_type'], $_POST['invoice_number'], $_POST['beleg_datum'], $_POST['beleg_time'],$_POST['payment_reminder'], $system->checkMagicQuotes($_POST['protocol_payment_reminder']), $system->checkMagicQuotes($_POST['protocol_invoice']),$_POST['documents'],$_POST['invoice_access'],$_POST['invoice_access_orig']));
		break;
		case 'sendDetails':
			echo($patientsInvoices->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($patientsInvoices->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>