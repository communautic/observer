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

include_once(CO_INC . "/apps/projects/modules/documents/config.php");
include_once(CO_INC . "/apps/projects/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/documents/model.php");
include_once(CO_INC . "/apps/projects/modules/documents/controller.php");

$projectsDocuments = new ProjectsDocuments("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsDocuments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($projectsDocuments->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($projectsDocuments->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($projectsDocuments->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($projectsDocuments->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($projectsDocuments->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($projectsDocuments->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("projects-documents-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projectsDocuments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($projectsDocuments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($projectsDocuments->getSendtoDetails("projects_documents",$_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($projectsDocuments->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($projectsDocuments->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$projectsDocuments->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($projectsDocuments->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($projectsDocuments->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($projectsDocuments->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($projectsDocuments->deleteFile($_GET['id']));
		break;
		case 'getHelp':
			echo($projectsDocuments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($projectsDocuments->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($projectsDocuments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}
?>