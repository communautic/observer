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
include_once(CO_INC . "/apps/productions/modules/vdocs/config.php");
include_once(CO_INC . "/apps/productions/modules/vdocs/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/productions/modules/vdocs/model.php");
include_once(CO_INC . "/apps/productions/modules/vdocs/controller.php");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($productionsVDocs->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($productionsVDocs->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($productionsVDocs->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($productionsVDocs->createDuplicate($_GET['id']));
		break;
		case 'binVDoc':
			echo($productionsVDocs->binVDoc($_GET['id']));
		break;
		case 'restoreVDoc':
			echo($productionsVDocs->restoreVDoc($_GET['id']));
		break;
			case 'deleteVDoc':
			echo($productionsVDocs->deleteVDoc($_GET['id']));
		break;
		case 'setOrder':
			echo($productions->setSortOrder("productions-vdocs-sort",$_GET['vdocItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productionsVDocs->printDetails($_GET['id'],$t));
		break;
		case 'exportDetails':
			echo($productionsVDocs->exportDetails($_GET['id']));
		break;
		case 'getSend':
			echo($productionsVDocs->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($productionsVDocs->getSendtoDetails("productions_vdocs",$_GET['id']));
		break;
		case 'checkinVDoc':
			echo($productionsVDocs->checkinVDoc($_GET['id']));
		break;
		case 'toggleIntern':
			echo($productionsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'toggleIntern':
			echo($productionsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getHelp':
			echo($productionsVDocs->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($productionsVDocs->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotesTinyMCE($_POST['content']),$_POST['vdoc_access'],$_POST['vdoc_access_orig']));
		break;
		case 'sendDetails':
			echo($productionsVDocs->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>