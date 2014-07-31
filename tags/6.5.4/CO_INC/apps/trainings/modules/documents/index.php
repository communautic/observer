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

include_once(CO_INC . "/apps/trainings/modules/documents/config.php");
include_once(CO_INC . "/apps/trainings/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/trainings/modules/documents/model.php");
include_once(CO_INC . "/apps/trainings/modules/documents/controller.php");

$trainingsDocuments = new TrainingsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainingsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($trainingsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($trainingsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($trainingsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($trainingsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($trainingsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($trainingsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($trainings->setSortOrder("trainings-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainingsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($trainingsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($trainingsDocuments->getSendtoDetails("trainings_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($trainingsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($trainingsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$trainingsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($trainingsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($trainingsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($trainingsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($trainingsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($trainingsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($trainingsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($trainingsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>