<?php
include_once(CO_INC . "/classes/ajax_header.inc");
include_once(CO_INC . "/model.php");
include_once(CO_INC . "/controller.php");
foreach($controller->applications as $app => $display) {
	include_once(CO_INC . "/apps/".$app."/config.php");
	include_once(CO_INC . "/apps/".$app."/lang/" . $session->userlang . ".php");
	
	if(file_exists(CO_PATH_BASE . "/lang/".$app."/" . $session->userlang . ".php")) {
		include_once(CO_PATH_BASE . "/test/" . $session->userlang . ".php");
	}
	include_once(CO_INC . "/apps/".$app."/model.php");
	include_once(CO_INC . "/apps/".$app."/controller.php");
}

// get dependend modules
include_once("modules/phases/config.php");
include_once("modules/phases/model.php");
//include_once("../phases/controller.php");

// GET requests
if (!empty($_GET['request'])) {
	
	switch ($_GET['request']) {
		case 'getFolderList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projects->getFolderList($sort));
		break;
		case 'getFolderDetails':
			echo($projects->getFolderDetails($_GET['id']));
		break;
		case 'setFolderOrder':
			echo($projects->setSortOrder("folder-sort",$_GET['folderItem']));
		break;
		case 'getFolderNew':
			echo($projects->getFolderNew());
		break;
		case 'newFolder':
			echo($projects->newFolder());
		break;
		case 'printFolderDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projects->printFolderDetails($_GET['id'],$t));
		break;
		case 'binFolder':
			echo($projects->binFolder($_GET['id']));
		break;
		case 'getProjectList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projects->getProjectList($_GET['id'],$sort));
		break;
		case 'setProjectOrder':
			echo($projects->setSortOrder("project-sort",$_GET['projectItem'],$_GET['id']));
		break;
		case 'getProjectDetails':
			echo($projects->getProjectDetails($_GET['id']));
		break;
		case 'getDates':
			echo($projects->getDates($_GET['id']));
		break;
		case 'printProjectDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projects->printProjectDetails($_GET['id'],$t));
		break;
		case 'newProject':
			echo($projects->newProject($_GET['id']));
		break;
		case 'createDuplicate':
			echo($projects->createDuplicate($_GET['id']));
		break;
		case 'binProject':
			echo($projects->binProject($_GET['id']));
		break;
		// get Groups for Dialogs
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getContactsDialogPlace':
			echo($contacts->getContactsDialogPlace($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		// get Pfolder Dialog
		case 'getProjectFolderDialog':
			echo($projects->getProjectFolderDialog($_GET['field'],$_GET['title']));
		break;
		case 'getProjectStatusDialog':
			echo($projects->getProjectStatusDialog());
		break;
		case 'getAccessDialog':
			echo($projects->getAccessDialog());
		break;
		/*case 'getPhaseDetails':
			echo($projects->getPhaseDetails($_GET['id'],$_GET['num']));
		break;*/
	}
}

// GET requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($projects->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['projectstatus']));
		break;
		/*case 'newFolder':
			echo($projects->newFolder($system->checkMagicQuotes($_POST['title']), $_POST['projectstatus']));
		break;*/
		case 'setProjectDetails':
			echo($projects->setProjectDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['projectfolder'], $_POST['status'], $_POST['status_date']));
		break;
		/*case 'newProject':
			echo($projects->newProject($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['startdate'], $_POST['enddate'], $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST['projectfolder'], $_POST['status'], $_POST['status_date']));
		break;*/
		case 'moveProject':
			echo($projects->moveProject($_POST['id'], $_POST['startdate'], $_POST['movedays']));
		break;
	}
}

?>