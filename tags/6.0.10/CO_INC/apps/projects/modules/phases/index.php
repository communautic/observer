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

$projectsPhases = new ProjectsPhases("phases");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsPhases->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($projectsPhases->getDetails($_GET['id'],$_GET['num']));
		break;
		case 'createNew':
			echo($projectsPhases->createNew($_GET['id'],$_GET['num']));
		break;
		case 'createDuplicate':
			echo($projectsPhases->createDuplicate($_GET['id']));
		break;
		case 'binPhase':
			echo($projectsPhases->binPhase($_GET['id']));
		break;
		case 'restorePhase':
			echo($projectsPhases->restorePhase($_GET['id']));
		break;
		case 'deletePhase':
			echo($projectsPhases->deletePhase($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("phase-sort",$_GET['phaseItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projectsPhases->printDetails($_GET['id'],$_GET['num'],$t));
		break;
		case 'getSend':
			echo($projectsPhases->getSend($_GET['id'],$_GET['num']));
		break;
		case 'getSendtoDetails':
			echo($projectsPhases->getSendtoDetails("phases",$_GET['id']));
		break;
		case 'checkinPhase':
			echo($projectsPhases->checkinPhase($_GET['id']));
		break;
		case 'toggleIntern':
			echo($projectsPhases->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getPhaseTaskDialog':
			echo($projectsPhases->getPhaseTaskDialog());
		break;
		case 'getTasksDialog':
			echo($projectsPhases->getTasksDialog($_GET['sql'],$_GET['field']));
		break;
		case 'getTaskDependencyExists':
			echo($projectsPhases->getTaskDependencyExists($_GET['id']));
		break;
		case 'moveDependendTasks':
			echo($projectsPhases->moveDependendTasks($_GET['id'],$_GET['days']));
		break;
		case 'addTask':
			echo($projectsPhases->addTask($_GET['pid'],$_GET['phid'],$_GET['date'],$_GET['cat']));
		break;
		case 'deleteTask':
			echo($projectsPhases->deleteTask($_GET['id']));
		break;
		case 'restorePhaseTask':
			echo($projectsPhases->restorePhaseTask($_GET['id']));
		break;
		case 'deletePhaseTask':
			echo($projectsPhases->deletePhaseTask($_GET['id']));
		break;
		case 'getPhaseStatusDialog':
			echo($projectsPhases->getPhaseStatusDialog());
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
				$task_text_orig = $_POST['task_text'];
				$task_text = "";
				foreach ($task_text_orig as $key => $text) {
					$text_new = $system->checkMagicQuotes($text);
					$task_text[$key] = $text_new;
				}
				$task_cat = $_POST['task_cat'];
				$task_dependent = $_POST['task_dependent'];
				$task_team = $_POST['task_team'];
				$task_team_ct = $_POST['task_team_ct'];
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			echo($projectsPhases->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST["documents"],$_POST['phase_access'], $_POST['phase_access_orig'], $_POST['phase_status'], $_POST['phase_status_date'],$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task,$task_cat,$task_dependent,$task_team,$task_team_ct));
		break;
		case 'sendDetails':
			echo($projectsPhases->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>