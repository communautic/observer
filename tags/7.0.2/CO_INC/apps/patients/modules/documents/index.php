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

include_once(CO_INC . "/apps/patients/modules/documents/config.php");
include_once(CO_INC . "/apps/patients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/documents/model.php");
include_once(CO_INC . "/apps/patients/modules/documents/controller.php");

$patientsDocuments = new PatientsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($patientsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($patientsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($patientsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($patientsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($patientsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($patientsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patientsDocuments->getSendtoDetails("patients_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($patientsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($patientsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$patientsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($patientsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($patientsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($patientsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($patientsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($patientsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($patientsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($patientsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>