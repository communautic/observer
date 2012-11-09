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

include_once(CO_INC . "/apps/complaints/modules/documents/config.php");
include_once(CO_INC . "/apps/complaints/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/complaints/modules/documents/model.php");
include_once(CO_INC . "/apps/complaints/modules/documents/controller.php");

$complaintsDocuments = new ComplaintsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($complaintsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($complaintsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($complaintsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($complaintsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($complaintsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($complaintsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($complaintsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($complaints->setSortOrder("complaints-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($complaintsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($complaintsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($complaintsDocuments->getSendtoDetails("complaints_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($complaintsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($complaintsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$complaintsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($complaintsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($complaintsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($complaintsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($complaintsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($complaintsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($complaintsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($complaintsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>