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
//include_once(CO_INC . "/apps/evals/modules/phases/config.php");
//include_once(CO_INC . "/apps/evals/modules/phases/model.php");
//include_once(CO_INC . "/apps/evals/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/evals/modules/documents/config.php");
include_once(CO_INC . "/apps/evals/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/evals/modules/documents/model.php");
include_once(CO_INC . "/apps/evals/modules/documents/controller.php");


// Objectives
include_once(CO_INC . "/apps/evals/modules/objectives/config.php");
include_once(CO_INC . "/apps/evals/modules/objectives/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/evals/modules/objectives/model.php");
include_once(CO_INC . "/apps/evals/modules/objectives/controller.php");
$evalsObjectives = new EvalsObjectives("objectives");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($evalsObjectives->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($evalsObjectives->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($evalsObjectives->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($evalsObjectives->createDuplicate($_GET['id']));
		break;
		case 'binObjective':
			echo($evalsObjectives->binObjective($_GET['id']));
		break;
		case 'restoreObjective':
			echo($evalsObjectives->restoreObjective($_GET['id']));
		break;
			case 'deleteObjective':
			echo($evalsObjectives->deleteObjective($_GET['id']));
		break;
		case 'setOrder':
			echo($evals->setSortOrder("evals-objectives-sort",$_GET['objectiveItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evalsObjectives->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($evalsObjectives->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($evalsObjectives->getSendtoDetails("evals_objectives",$_GET['id']));
		break;
		case 'checkinObjective':
			echo($evalsObjectives->checkinObjective($_GET['id']));
		break;
		case 'toggleIntern':
			echo($evalsObjectives->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($evalsObjectives->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($evalsObjectives->deleteTask($_GET['id']));
		break;
		case 'restoreObjectiveTask':
			echo($evalsObjectives->restoreObjectiveTask($_GET['id']));
		break;
			case 'deleteObjectiveTask':
			echo($evalsObjectives->deleteObjectiveTask($_GET['id']));
		break;
		case 'getObjectiveStatusDialog':
			echo($evalsObjectives->getObjectiveStatusDialog());
		break;
		case 'getObjectiveCatDialog':
			echo($evalsObjectives->getObjectiveCatDialog($_GET['field'],$_GET['title']));
		break;
		case 'changeCat':
			echo($evalsObjectives->changeCat($_GET['id'],$_GET['cat']));
		break;
		case 'getHelp':
			echo($evalsObjectives->getHelp());
		break;
		case 'newCheckpoint':
			echo($evalsObjectives->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($evalsObjectives->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($evalsObjectives->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($evalsObjectives->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'updateQuestion':
			echo($evalsObjectives->updateQuestion($_GET['id'],$_GET['field'],$_GET['val']));
		break;
		case 'updateTaskQuestion':
			echo($evalsObjectives->updateTaskQuestion($_GET['id'],$_GET['val']));
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
			echo($evalsObjectives->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['objectivestart'], $_POST['objectiveend'], $_POST['location'], $system->checkMagicQuotes($_POST['location_ct']), $_POST['participants'], $system->checkMagicQuotes($_POST['participants_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['protocol']), $system->checkMagicQuotes($_POST['protocol2']), $system->checkMagicQuotes($_POST['tab1q1_text']), $system->checkMagicQuotes($_POST['tab1q2_text']), $system->checkMagicQuotes($_POST['tab1q3_text']), $system->checkMagicQuotes($_POST['tab1q4_text']), $system->checkMagicQuotes($_POST['tab1q5_text']), $system->checkMagicQuotes($_POST['tab1q6_text']), $system->checkMagicQuotes($_POST['tab1q7_text']), $system->checkMagicQuotes($_POST['tab1q8_text']), $system->checkMagicQuotes($_POST['tab1q9_text']), $system->checkMagicQuotes($_POST['tab1q10_text']), $system->checkMagicQuotes($_POST['tab1q11_text']), $system->checkMagicQuotes($_POST['tab1q12_text']), $system->checkMagicQuotes($_POST['tab1q13_text']), $system->checkMagicQuotes($_POST['tab1q14_text']), $system->checkMagicQuotes($_POST['tab1q15_text']), $system->checkMagicQuotes($_POST['tab1q16_text']), $system->checkMagicQuotes($_POST['tab1q17_text']), $system->checkMagicQuotes($_POST['tab2q1_text']), $system->checkMagicQuotes($_POST['tab2q2_text']), $system->checkMagicQuotes($_POST['tab2q3_text']), $system->checkMagicQuotes($_POST['tab2q4_text']), $system->checkMagicQuotes($_POST['tab2q5_text']), $system->checkMagicQuotes($_POST['tab2q6_text']), $system->checkMagicQuotes($_POST['tab2q7_text']), $system->checkMagicQuotes($_POST['tab2q8_text']), $system->checkMagicQuotes($_POST['tab2q9_text']), $system->checkMagicQuotes($_POST['tab2q10_text']), $system->checkMagicQuotes($_POST['tab2q11_text']), $system->checkMagicQuotes($_POST['tab2q12_text']), $system->checkMagicQuotes($_POST['tab2q13_text']), $system->checkMagicQuotes($_POST['tab2q14_text']), $system->checkMagicQuotes($_POST['tab2q15_text']), $system->checkMagicQuotes($_POST['tab2q16_text']), $system->checkMagicQuotes($_POST['tab2q17_text']), $system->checkMagicQuotes($_POST['tab3q1_text']), $system->checkMagicQuotes($_POST['tab3q2_text']), $system->checkMagicQuotes($_POST['tab3q3_text']), $system->checkMagicQuotes($_POST['tab3q4_text']), $system->checkMagicQuotes($_POST['tab3q5_text']), $system->checkMagicQuotes($_POST['tab3q6_text']), $system->checkMagicQuotes($_POST['tab3q7_text']), $system->checkMagicQuotes($_POST['tab3q8_text']), $system->checkMagicQuotes($_POST['tab3q9_text']), $system->checkMagicQuotes($_POST['tab3q10_text']), $system->checkMagicQuotes($_POST['tab3q11_text']), $system->checkMagicQuotes($_POST['tab3q12_text']), $system->checkMagicQuotes($_POST['tab3q13_text']), $system->checkMagicQuotes($_POST['tab3q14_text']), $system->checkMagicQuotes($_POST['tab3q15_text']), $system->checkMagicQuotes($_POST['tab3q16_text']), $system->checkMagicQuotes($_POST['tab3q17_text']),$task_id,$task_title,$task_text,$task,$_POST['objective_access'],$_POST['objective_access_orig']));
		break;
		case 'sendDetails':
			echo($evalsObjectives->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($evalsObjectives->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>