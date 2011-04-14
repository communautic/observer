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

// get dependend modules
include_once(CO_INC . "/apps/projects/modules/documents/config.php");
include_once(CO_INC . "/apps/projects/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/documents/model.php");
include_once(CO_INC . "/apps/projects/modules/documents/controller.php");

include_once(CO_INC . "/apps/projects/modules/phases/config.php");
include_once(CO_INC . "/apps/projects/modules/phases/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/phases/model.php");
include_once(CO_INC . "/apps/projects/modules/phases/controller.php");

$phases = new Phases("phases");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($phases->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($phases->getDetails($_GET['id'],$_GET['num']));
		break;
		case 'createNew':
			echo($phases->createNew($_GET['id'],$_GET['num']));
		break;
		case 'createDuplicate':
			echo($phases->createDuplicate($_GET['id']));
		break;
		case 'binPhase':
			echo($phases->binPhase($_GET['id']));
		break;
		case 'restorePhase':
			echo($phases->restorePhase($_GET['id']));
		break;
		case 'deletePhase':
			echo($phases->deletePhase($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("phase-sort",$_GET['phaseItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($phases->printDetails($_GET['id'],$_GET['num'],$t));
		break;
		case 'getSend':
			echo($phases->getSend($_GET['id'],$_GET['num']));
		break;
		case 'getSendtoDetails':
			echo($phases->getSendtoDetails("phases",$_GET['id']));
		break;
		case 'toggleIntern':
			echo($phases->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getPhaseTaskDialog':
			echo($phases->getPhaseTaskDialog());
		break;
		case 'getTasksDialog':
			echo($phases->getTasksDialog($_GET['sql'],$_GET['field']));
		break;
		case 'addTask':
			echo($phases->addTask($_GET['pid'],$_GET['phid'],$_GET['date'],$_GET['cat']));
		break;
		case 'deleteTask':
			echo($phases->deleteTask($_GET['id']));
		break;
		case 'restorePhaseTask':
			echo($phases->restorePhaseTask($_GET['id']));
		break;
		case 'deletePhaseTask':
			echo($phases->deletePhaseTask($_GET['id']));
		break;
		case 'getPhaseStatusDialog':
			echo($phases->getPhaseStatusDialog());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			
			$task_startdate = array();
			$task_enddate = array();
			$task_id = array();
			$task_cat = array();
			$task_dependent = array();
			$task_text = array();
			$task = array();
			$task_team = array();
			$task_team_ct = array();
			
			if(isset($_POST['task_id'])) {
				$task_startdate = $_POST['task_startdate'];
				$task_enddate = $_POST['task_enddate'];
				$task_donedate = $_POST['task_donedate'];
				$task_id = $_POST['task_id'];
				$task_text = $_POST['task_text'];
				$task_cat = $_POST['task_cat'];
				$task_dependent = $_POST['task_dependent'];
				$task_team = $_POST['task_team'];
				$task_team_ct = $_POST['task_team_ct'];
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			echo($phases->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotesTinyMCE($_POST['protocol']), $_POST["documents"],$_POST['phase_access'], $_POST['phase_access_orig'], $_POST['phase_status'], $_POST['phase_status_date'],$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task,$task_cat,$task_dependent,$task_team,$task_team_ct));
		break;
		case 'sendDetails':
			echo($phases->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotes($_POST['subject']), $system->checkMagicQuotes($_POST['body'])));
		break;
	}
}

?>