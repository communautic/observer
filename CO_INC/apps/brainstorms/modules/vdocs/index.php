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
include_once(CO_INC . "/apps/brainstorms/modules/vdocs/config.php");
include_once(CO_INC . "/apps/brainstorms/modules/vdocs/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/brainstorms/modules/vdocs/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/vdocs/controller.php");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($brainstormsVDocs->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($brainstormsVDocs->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($brainstormsVDocs->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($brainstormsVDocs->createDuplicate($_GET['id']));
		break;
		case 'binVDoc':
			echo($brainstormsVDocs->binVDoc($_GET['id']));
		break;
		case 'restoreVDoc':
			echo($brainstormsVDocs->restoreVDoc($_GET['id']));
		break;
			case 'deleteVDoc':
			echo($brainstormsVDocs->deleteVDoc($_GET['id']));
		break;
		case 'setOrder':
			echo($brainstorms->setSortOrder("brainstorms-vdocs-sort",$_GET['vdocItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstormsVDocs->printDetails($_GET['id'],$t));
		break;
		case 'exportDetails':
			echo($brainstormsVDocs->exportDetails($_GET['id']));
		break;
		case 'getSend':
			echo($brainstormsVDocs->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($brainstormsVDocs->getSendtoDetails("brainstorms_vdocs",$_GET['id']));
		break;
		case 'checkinVDoc':
			echo($brainstormsVDocs->checkinVDoc($_GET['id']));
		break;
		case 'toggleIntern':
			echo($brainstormsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'toggleIntern':
			echo($brainstormsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getHelp':
			echo($brainstormsVDocs->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($brainstormsVDocs->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotesTinyMCE($_POST['content']),$_POST['vdoc_access'],$_POST['vdoc_access_orig']));
		break;
		case 'sendDetails':
			echo($brainstormsVDocs->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>