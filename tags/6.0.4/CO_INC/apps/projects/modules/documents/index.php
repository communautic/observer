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

$documents = new Documents("documents");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($documents->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($documents->getDetails($_GET['id']));
		break;
		/*case 'getNew':
			echo($documents->getNew($_GET['id']));
		break;*/
		case 'createDuplicate':
			echo($documents->createDuplicate($_GET['id']));
		break;
		case 'binDocument':
			echo($documents->binDocument($_GET['id']));
		break;
		case 'restoreDocument':
			echo($documents->restoreDocument($_GET['id']));
		break;
		case 'deleteDocument':
			echo($documents->deleteDocument($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("document-sort",$_GET['documentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($documents->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($documents->getSend($_GET['id']));
		break;
		case 'getDocumentsDialog':
			echo($documents->getDocumentsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql'],$_GET['id']));
		break;
		case 'createNew':
			echo($documents->createNew($_GET['id']));
		break;
		case 'downloadDocument':
			$documents->downloadDocument($_GET['id']);
		break;
		case 'getDocContext':
			echo($documents->getDocContext($_GET['id'],$_GET['field']));
		break;
		case 'binDocItem':
			echo($documents->binDocItem($_GET['id']));
		break;
		case 'restoreFile':
			echo($documents->restoreFile($_GET['id']));
		break;
		case 'deleteFile':
			echo($documents->deleteFile($_GET['id']));
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setDetails':
			echo($documents->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']),$_POST['document_access']));
		break;
		case 'sendDetails':
			echo($documents->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotes($_POST['subject']), $system->checkMagicQuotes($_POST['body'])));
		break;
	}
}
?>