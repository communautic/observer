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
//$projectsVDocs = new ProjectsVDocs("vdocs");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsVDocs->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($projectsVDocs->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($projectsVDocs->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($projectsVDocs->createDuplicate($_GET['id']));
		break;
		case 'binVDoc':
			echo($projectsVDocs->binVDoc($_GET['id']));
		break;
		case 'restoreVDoc':
			echo($projectsVDocs->restoreVDoc($_GET['id']));
		break;
			case 'deleteVDoc':
			echo($projectsVDocs->deleteVDoc($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("projects-vdocs-sort",$_GET['vdocItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projectsVDocs->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($projectsVDocs->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($projectsVDocs->getSendtoDetails("projects_vdocs",$_GET['id']));
		break;
		case 'checkinVDoc':
			echo($projectsVDocs->checkinVDoc($_GET['id']));
		break;
		case 'toggleIntern':
			echo($projectsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'toggleIntern':
			echo($projectsVDocs->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getHelp':
			echo($projectsVDocs->getHelp());
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($projectsVDocs->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotesTinyMCE($_POST['content']),$_POST['vdoc_access'],$_POST['vdoc_access_orig']));
		break;
		case 'sendDetails':
			echo($projectsVDocs->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>