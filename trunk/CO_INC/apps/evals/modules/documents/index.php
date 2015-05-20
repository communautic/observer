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

include_once(CO_INC . "/apps/evals/modules/documents/config.php");
include_once(CO_INC . "/apps/evals/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/evals/modules/documents/model.php");
include_once(CO_INC . "/apps/evals/modules/documents/controller.php");

$evalsDocuments = new EvalsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($evalsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($evalsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($evalsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($evalsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($evalsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($evalsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($evalsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($evals->setSortOrder("evals-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evalsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($evalsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($evalsDocuments->getSendtoDetails("evals_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($evalsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($evalsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$evalsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($evalsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($evalsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($evalsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($evalsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($evalsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($evalsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($evalsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>