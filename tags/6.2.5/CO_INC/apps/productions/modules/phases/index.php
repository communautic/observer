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
include_once(CO_INC . "/apps/productions/modules/documents/config.php");
include_once(CO_INC . "/apps/productions/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/productions/modules/documents/model.php");
include_once(CO_INC . "/apps/productions/modules/documents/controller.php");

include_once(CO_INC . "/apps/productions/modules/phases/config.php");
include_once(CO_INC . "/apps/productions/modules/phases/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/productions/modules/phases/model.php");
include_once(CO_INC . "/apps/productions/modules/phases/controller.php");

$productionsPhases = new ProductionsPhases("phases");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($productionsPhases->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($productionsPhases->getDetails($_GET['id'],$_GET['num']));
		break;
		case 'createNew':
			echo($productionsPhases->createNew($_GET['id'],$_GET['num']));
		break;
		case 'createDuplicate':
			echo($productionsPhases->createDuplicate($_GET['id']));
		break;
		case 'binPhase':
			echo($productionsPhases->binPhase($_GET['id']));
		break;
		case 'restorePhase':
			echo($productionsPhases->restorePhase($_GET['id']));
		break;
		case 'deletePhase':
			echo($productionsPhases->deletePhase($_GET['id']));
		break;
		case 'setOrder':
			echo($productions->setSortOrder("productions-phases-sort",$_GET['phaseItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productionsPhases->printDetails($_GET['id'],$_GET['num'],$t));
		break;
		case 'getSend':
			echo($productionsPhases->getSend($_GET['id'],$_GET['num']));
		break;
		case 'getSendtoDetails':
			echo($productionsPhases->getSendtoDetails("productions_phases",$_GET['id']));
		break;
		case 'checkinPhase':
			echo($productionsPhases->checkinPhase($_GET['id']));
		break;
		case 'toggleIntern':
			echo($productionsPhases->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getPhaseTaskDialog':
			echo($productionsPhases->getPhaseTaskDialog());
		break;
		case 'getTasksDialog':
			echo($productionsPhases->getTasksDialog($_GET['sql'],$_GET['field']));
		break;
		case 'getTaskDependencyExists':
			echo($productionsPhases->getTaskDependencyExists($_GET['id']));
		break;
		case 'moveDependendTasks':
			echo($productionsPhases->moveDependendTasks($_GET['id'],$_GET['days']));
		break;
		case 'addTask':
			echo($productionsPhases->addTask($_GET['pid'],$_GET['phid'],$_GET['date'],$_GET['cat']));
		break;
		case 'deleteTask':
			echo($productionsPhases->deleteTask($_GET['id']));
		break;
		case 'restorePhaseTask':
			echo($productionsPhases->restorePhaseTask($_GET['id']));
		break;
		case 'deletePhaseTask':
			echo($productionsPhases->deletePhaseTask($_GET['id']));
		break;
		case 'getPhaseStatusDialog':
			echo($productionsPhases->getPhaseStatusDialog());
		break;
		case 'getHelp':
			echo($productionsPhases->getHelp());
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
			$task_protocol = array();
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
				$task_protocol_orig = $_POST['task_protocol'];
				$task_protocol = "";
				foreach ($task_protocol_orig as $key => $protocol) {
					$protocol_new = $system->checkMagicQuotes($protocol);
					$task_protocol[$key] = $protocol_new;
				}
				$task_cat = $_POST['task_cat'];
				$task_dependent = $_POST['task_dependent'];
				$task_team = $_POST['task_team'];
				$task_team_ct = $_POST['task_team_ct'];
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			echo($productionsPhases->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['team'], $system->checkMagicQuotes($_POST['team_ct']), $system->checkMagicQuotes($_POST['protocol']), $_POST["documents"],$_POST['phase_access'], $_POST['phase_access_orig'], $_POST['phase_status'], $_POST['phase_status_date'],$task_startdate,$task_enddate,$task_donedate,$task_id,$task_text,$task_protocol,$task,$task_cat,$task_dependent,$task_team,$task_team_ct));
		break;
		case 'sendDetails':
			echo($productionsPhases->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>