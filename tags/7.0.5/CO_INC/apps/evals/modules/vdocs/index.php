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

// VDocs
include_once(CO_INC . "/apps/evals/modules/vdocs/config.php");
include_once(CO_INC . "/apps/evals/modules/vdocs/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/evals/modules/vdocs/model.php");
include_once(CO_INC . "/apps/evals/modules/vdocs/controller.php");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($evalsVDocs->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($evalsVDocs->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($evalsVDocs->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($evalsVDocs->createDuplicate($_GET['id']));
		break;
		case 'binVDoc':
			echo($evalsVDocs->binVDoc($_GET['id']));
		break;
		case 'restoreVDoc':
			echo($evalsVDocs->restoreVDoc($_GET['id']));
		break;
			case 'deleteVDoc':
			echo($evalsVDocs->deleteVDoc($_GET['id']));
		break;
		case 'setOrder':
			echo($evals->setSortOrder("evals-vdocs-sort",$_GET['vdocItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evalsVDocs->printDetails($_GET['id'],$t));
		break;
		case 'exportDetails':
			echo($evalsVDocs->exportDetails($_GET['id']));
		break;
		case 'getSend':
			echo($evalsVDocs->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($evalsVDocs->getSendtoDetails("evals_vdocs",$_GET['id']));
		break;
		case 'checkinVDoc':
			echo($evalsVDocs->checkinVDoc($_GET['id']));
		break;
		case 'toggleIntern':
			echo($evalsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'toggleIntern':
			echo($evalsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getHelp':
			echo($evalsVDocs->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($evalsVDocs->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotesTinyMCE($_POST['content']),$_POST['vdoc_access'],$_POST['vdoc_access_orig']));
		break;
		case 'sendDetails':
			echo($evalsVDocs->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>