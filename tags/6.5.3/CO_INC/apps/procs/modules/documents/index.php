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

include_once(CO_INC . "/apps/procs/modules/documents/config.php");
include_once(CO_INC . "/apps/procs/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/documents/model.php");
include_once(CO_INC . "/apps/procs/modules/documents/controller.php");

$procsDocuments = new ProcsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($procsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($procsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($procsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($procsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($procsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($procsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($procsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($procs->setSortOrder("procs-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($procsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($procsDocuments->getSendtoDetails("procs_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($procsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($procsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$procsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($procsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($procsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($procsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($procsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($procsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($procsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($procsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>