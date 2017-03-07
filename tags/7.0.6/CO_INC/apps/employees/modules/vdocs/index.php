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
include_once(CO_INC . "/apps/employees/modules/vdocs/config.php");
include_once(CO_INC . "/apps/employees/modules/vdocs/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/vdocs/model.php");
include_once(CO_INC . "/apps/employees/modules/vdocs/controller.php");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($employeesVDocs->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($employeesVDocs->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($employeesVDocs->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($employeesVDocs->createDuplicate($_GET['id']));
		break;
		case 'binVDoc':
			echo($employeesVDocs->binVDoc($_GET['id']));
		break;
		case 'restoreVDoc':
			echo($employeesVDocs->restoreVDoc($_GET['id']));
		break;
			case 'deleteVDoc':
			echo($employeesVDocs->deleteVDoc($_GET['id']));
		break;
		case 'setOrder':
			echo($employees->setSortOrder("employees-vdocs-sort",$_GET['vdocItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employeesVDocs->printDetails($_GET['id'],$t));
		break;
		case 'exportDetails':
			echo($employeesVDocs->exportDetails($_GET['id']));
		break;
		case 'getSend':
			echo($employeesVDocs->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($employeesVDocs->getSendtoDetails("employees_vdocs",$_GET['id']));
		break;
		case 'checkinVDoc':
			echo($employeesVDocs->checkinVDoc($_GET['id']));
		break;
		case 'toggleIntern':
			echo($employeesVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'toggleIntern':
			echo($employeesVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getHelp':
			echo($employeesVDocs->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($employeesVDocs->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotesTinyMCE($_POST['content']),$_POST['vdoc_access'],$_POST['vdoc_access_orig']));
		break;
		case 'sendDetails':
			echo($employeesVDocs->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>