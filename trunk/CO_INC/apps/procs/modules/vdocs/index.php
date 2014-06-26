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
include_once(CO_INC . "/apps/procs/modules/vdocs/config.php");
include_once(CO_INC . "/apps/procs/modules/vdocs/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/vdocs/model.php");
include_once(CO_INC . "/apps/procs/modules/vdocs/controller.php");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			$fid = 0;
			if(!empty($_GET['fid'])) {
				$fid = $_GET['fid'];
			}
			echo($procsVDocs->getList($_GET['id'],$sort,$fid));
		break;
		case 'getDetails':
			echo($procsVDocs->getDetails($_GET['id'],$_GET['fid']));
		break;
		case 'createNew':
			echo($procsVDocs->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($procsVDocs->createDuplicate($_GET['id']));
		break;
		case 'binVDoc':
			echo($procsVDocs->binVDoc($_GET['id']));
		break;
		case 'restoreVDoc':
			echo($procsVDocs->restoreVDoc($_GET['id']));
		break;
			case 'deleteVDoc':
			echo($procsVDocs->deleteVDoc($_GET['id']));
		break;
		case 'setOrder':
			echo($procs->setSortOrder("procs-vdocs-sort",$_GET['vdocItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procsVDocs->printDetails($_GET['id'],$t));
		break;
		case 'exportDetails':
			echo($procsVDocs->exportDetails($_GET['id']));
		break;
		case 'getSend':
			echo($procsVDocs->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($procsVDocs->getSendtoDetails("procs_vdocs",$_GET['id']));
		break;
		case 'checkinVDoc':
			echo($procsVDocs->checkinVDoc($_GET['id']));
		break;
		case 'toggleIntern':
			echo($procsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'toggleIntern':
			echo($procsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getHelp':
			echo($procsVDocs->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($procsVDocs->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotesTinyMCE($_POST['content']),$_POST['vdoc_access'],$_POST['vdoc_access_orig']));
		break;
		case 'sendDetails':
			echo($procsVDocs->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>