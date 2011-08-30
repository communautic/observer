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


// get dependend module phases
include_once(CO_INC . "/apps/projects/modules/phases/config.php");
include_once(CO_INC . "/apps/projects/modules/phases/model.php");
include_once(CO_INC . "/apps/projects/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/projects/modules/documents/config.php");
include_once(CO_INC . "/apps/projects/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/documents/model.php");
include_once(CO_INC . "/apps/projects/modules/documents/controller.php");


// VDocs
include_once(CO_INC . "/apps/projects/modules/vdocs/config.php");
include_once(CO_INC . "/apps/projects/modules/vdocs/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/vdocs/model.php");
include_once(CO_INC . "/apps/projects/modules/vdocs/controller.php");
$vdocs = new VDocs("vdocs");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($vdocs->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($vdocs->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($vdocs->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($vdocs->createDuplicate($_GET['id']));
		break;
		case 'binVDoc':
			echo($vdocs->binVDoc($_GET['id']));
		break;
		case 'restoreVDoc':
			echo($vdocs->restoreVDoc($_GET['id']));
		break;
			case 'deleteVDoc':
			echo($vdocs->deleteVDoc($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("vdoc-sort",$_GET['vdocItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($vdocs->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($vdocs->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($vdocs->getSendtoDetails("projects_vdocs",$_GET['id']));
		break;
		case 'toggleIntern':
			echo($vdocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'toggleIntern':
			echo($vdocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($vdocs->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['content']),$_POST['vdoc_access'],$_POST['vdoc_access_orig']));
		break;
		case 'sendDetails':
			echo($vdocs->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>