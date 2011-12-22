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

include_once(CO_INC . "/apps/brainstorms/modules/documents/config.php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/controller.php");

$brainstormsDocuments = new BrainstormsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($brainstormsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($brainstormsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($brainstormsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($brainstormsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($brainstormsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($brainstormsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($brainstormsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($brainstorms->setSortOrder("brainstorms-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstormsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($brainstormsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($brainstormsDocuments->getSendtoDetails("brainstorms_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($brainstormsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($brainstormsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$brainstormsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($brainstormsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($brainstormsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($brainstormsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($brainstormsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($brainstormsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($brainstormsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($brainstormsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>