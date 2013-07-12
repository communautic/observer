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

include_once(CO_INC . "/apps/employees/modules/documents/config.php");
include_once(CO_INC . "/apps/employees/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/documents/model.php");
include_once(CO_INC . "/apps/employees/modules/documents/controller.php");

$employeesDocuments = new EmployeesDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($employeesDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($employeesDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($employeesDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($employeesDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($employeesDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($employeesDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($employeesDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($employees->setSortOrder("employees-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employeesDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($employeesDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($employeesDocuments->getSendtoDetails("employees_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($employeesDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($employeesDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$employeesDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($employeesDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($employeesDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($employeesDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($employeesDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($employeesDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($employeesDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($employeesDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>