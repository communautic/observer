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
//include_once(CO_INC . "/apps/employees/modules/phases/config.php");
//include_once(CO_INC . "/apps/employees/modules/phases/model.php");
//include_once(CO_INC . "/apps/employees/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/employees/modules/documents/config.php");
include_once(CO_INC . "/apps/employees/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/documents/model.php");
include_once(CO_INC . "/apps/employees/modules/documents/controller.php");


// Objectives
include_once(CO_INC . "/apps/employees/modules/objectives/config.php");
include_once(CO_INC . "/apps/employees/modules/objectives/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/objectives/model.php");
include_once(CO_INC . "/apps/employees/modules/objectives/controller.php");
$employeesObjectives = new EmployeesObjectives("objectives");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($employeesObjectives->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($employeesObjectives->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($employeesObjectives->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($employeesObjectives->createDuplicate($_GET['id']));
		break;
		case 'binObjective':
			echo($employeesObjectives->binObjective($_GET['id']));
		break;
		case 'restoreObjective':
			echo($employeesObjectives->restoreObjective($_GET['id']));
		break;
			case 'deleteObjective':
			echo($employeesObjectives->deleteObjective($_GET['id']));
		break;
		case 'setOrder':
			echo($employees->setSortOrder("employees-objectives-sort",$_GET['objectiveItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employeesObjectives->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($employeesObjectives->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($employeesObjectives->getSendtoDetails("employees_objectives",$_GET['id']));
		break;
		case 'checkinObjective':
			echo($employeesObjectives->checkinObjective($_GET['id']));
		break;
		case 'toggleIntern':
			echo($employeesObjectives->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($employeesObjectives->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($employeesObjectives->deleteTask($_GET['id']));
		break;
		case 'restoreObjectiveTask':
			echo($employeesObjectives->restoreObjectiveTask($_GET['id']));
		break;
			case 'deleteObjectiveTask':
			echo($employeesObjectives->deleteObjectiveTask($_GET['id']));
		break;
		case 'getObjectiveStatusDialog':
			echo($employeesObjectives->getObjectiveStatusDialog());
		break;
		case 'getHelp':
			echo($employeesObjectives->getHelp());
		break;
		case 'newCheckpoint':
			echo($employeesObjectives->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($employeesObjectives->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($employeesObjectives->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($employeesObjectives->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'updateQuestion':
			echo($employeesObjectives->updateQuestion($_GET['id'],$_GET['field'],$_GET['val']));
		break;
		case 'updateTaskQuestion':
			echo($employeesObjectives->updateTaskQuestion($_GET['id'],$_GET['val']));
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			$task_id = array();
			$task_title = array();
			$task_text = array();
			$task = array();
			
			if(isset($_POST['task_id'])) {
				$task_id = $_POST['task_id'];
				//$task_title = $_POST['task_title'];
				$task_title_orig = $_POST['task_title'];
				$task_title = "";
				foreach ($task_title_orig as $key => $text) {
					$text_new = $system->checkMagicQuotes($text);
					$task_title[$key] = $text_new;
				}
				$task_text_orig = $_POST['task_text'];
				$task_text = "";
				foreach ($task_text_orig as $key => $text) {
					$text_new = $system->checkMagicQuotes($text);
					$task_text[$key] = $text_new;
				}
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			if(isset($_POST['task_sort'])) {
				$task_sort = $_POST['task_sort'];
			}
			echo($employeesObjectives->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['objectivestart'], $_POST['objectiveend'], $_POST['location'], $system->checkMagicQuotes($_POST['location_ct']), $_POST['participants'], $system->checkMagicQuotes($_POST['participants_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['tab1q1_text']), $system->checkMagicQuotes($_POST['tab1q2_text']), $system->checkMagicQuotes($_POST['tab1q3_text']), $system->checkMagicQuotes($_POST['tab1q4_text']), $system->checkMagicQuotes($_POST['tab2q1_text']), $system->checkMagicQuotes($_POST['tab2q2_text']), $system->checkMagicQuotes($_POST['tab2q3_text']), $system->checkMagicQuotes($_POST['tab2q4_text']), $system->checkMagicQuotes($_POST['tab2q5_text']), $system->checkMagicQuotes($_POST['tab2q6_text']), $system->checkMagicQuotes($_POST['tab2q7_text']), $system->checkMagicQuotes($_POST['tab2q8_text']), $system->checkMagicQuotes($_POST['tab2q9_text']), $system->checkMagicQuotes($_POST['tab2q10_text']),$task_id,$task_title,$task_text,$task,$_POST['objective_access'],$_POST['objective_access_orig']));
		break;
		case 'sendDetails':
			echo($employeesObjectives->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($employeesObjectives->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>