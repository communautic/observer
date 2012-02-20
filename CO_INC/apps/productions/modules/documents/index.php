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

include_once(CO_INC . "/apps/productions/modules/documents/config.php");
include_once(CO_INC . "/apps/productions/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/productions/modules/documents/model.php");
include_once(CO_INC . "/apps/productions/modules/documents/controller.php");

$productionsDocuments = new ProductionsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($productionsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($productionsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($productionsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($productionsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($productionsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($productionsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($productionsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($productions->setSortOrder("productions-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productionsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($productionsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($productionsDocuments->getSendtoDetails("productions_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($productionsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($productionsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$productionsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($productionsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($productionsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($productionsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($productionsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($productionsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($productionsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($productionsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>