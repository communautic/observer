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

include_once(CO_INC . "/apps/clients/modules/documents/config.php");
include_once(CO_INC . "/apps/clients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/clients/modules/documents/model.php");
include_once(CO_INC . "/apps/clients/modules/documents/controller.php");

$clientsDocuments = new ClientsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($clientsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($clientsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($clientsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($clientsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($clientsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($clientsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($clientsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($clients->setSortOrder("clients-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($clientsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($clientsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($clientsDocuments->getSendtoDetails("clients_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($clientsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($clientsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$clientsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($clientsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($clientsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($clientsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($clientsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($clientsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($clientsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($clientsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>