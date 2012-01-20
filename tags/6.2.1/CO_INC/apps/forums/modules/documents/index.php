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

include_once(CO_INC . "/apps/forums/modules/documents/config.php");
include_once(CO_INC . "/apps/forums/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/forums/modules/documents/model.php");
include_once(CO_INC . "/apps/forums/modules/documents/controller.php");

$forumsDocuments = new ForumsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($forumsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($forumsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($forumsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($forumsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($forumsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($forumsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($forumsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($forums->setSortOrder("forums-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($forumsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($forumsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($forumsDocuments->getSendtoDetails("forums_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($forumsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($forumsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$forumsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($forumsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($forumsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($forumsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($forumsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($forumsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($forumsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($forumsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>