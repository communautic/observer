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
//include_once(CO_INC . "/apps/projects/modules/phases/config.php");
//include_once(CO_INC . "/apps/projects/modules/phases/model.php");
//include_once(CO_INC . "/apps/projects/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/projects/modules/documents/config.php");
include_once(CO_INC . "/apps/projects/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/documents/model.php");
include_once(CO_INC . "/apps/projects/modules/documents/controller.php");


// Sketches
include_once(CO_INC . "/apps/projects/modules/sketches/config.php");
include_once(CO_INC . "/apps/projects/modules/sketches/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/sketches/model.php");
include_once(CO_INC . "/apps/projects/modules/sketches/controller.php");
$projectsSketches = new ProjectsSketches("sketches");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsSketches->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($projectsSketches->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($projectsSketches->createNew($_GET['id'],$_GET['type'],$_GET['image']));
		break;
		case 'getNewOptions':
			echo($projectsSketches->getNewOptions());
		break;
		case 'createNewImage':
			echo($projectsSketches->createNewImage($_GET['id']));
		break;
		case 'createDuplicate':
			echo($projectsSketches->createDuplicate($_GET['id']));
		break;
		case 'binSketch':
			echo($projectsSketches->binSketch($_GET['id']));
		break;
		case 'restoreSketch':
			echo($projectsSketches->restoreSketch($_GET['id']));
		break;
			case 'deleteSketch':
			echo($projectsSketches->deleteSketch($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("projects-sketches-sort",$_GET['sketchItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projectsSketches->printDetails($_GET['id'],$t,$_GET['option']));
		break;
		case 'getPrintOptions':
			echo($projectsSketches->getPrintOptions());
		break;
		case 'getSendToOptions':
			echo($projectsSketches->getSendToOptions());
		break;
		case 'getSend':
			echo($projectsSketches->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($projectsSketches->getSendtoDetails("projects_sketches",$_GET['id']));
		break;
		case 'checkinSketch':
			echo($projectsSketches->checkinSketch($_GET['id']));
		break;
		case 'toggleIntern':
			echo($projectsSketches->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($projectsSketches->addTask($_GET['pid'],$_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($projectsSketches->deleteTask($_GET['id']));
		break;
		case 'restoreSketchTask':
			echo($projectsSketches->restoreSketchTask($_GET['id']));
		break;
			case 'deleteSketchTask':
			echo($projectsSketches->deleteSketchTask($_GET['id']));
		break;
		case 'restoreSketchDiagnose':
			echo($projectsSketches->restoreSketchDiagnose($_GET['id']));
		break;
			case 'deleteSketchDiagnose':
			echo($projectsSketches->deleteSketchDiagnose($_GET['id']));
		break;
		case 'getSketchStatusDialog':
			echo($projectsSketches->getSketchStatusDialog());
		break;
		case 'getSketchesTypeDialog':
			echo($projectsSketches->getSketchesTypeDialog($_GET['field'],$_GET['append']));
		break;
		case 'getHelp':
			echo($projectsSketches->getHelp());
		break;
		case 'newCheckpoint':
			echo($projectsSketches->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($projectsSketches->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($projectsSketches->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($projectsSketches->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		//diagnose
		case 'updatePosition':
			echo($projectsSketches->updatePosition($_GET['id'],$_GET['x'],$_GET['y']));
		break;
		case 'addDiagnose':
			echo($projectsSketches->addDiagnose($_GET['mid'],$_GET['num']));
		break;
		case 'binDiagnose':
			echo($projectsSketches->binDiagnose($_GET['id']));
		break;
		case 'getSketchTypeMin':
			echo($projectsSketches->getSketchTypeMin($_GET['id']));
		break;
		case 'getSketchesSearch':
			echo($projectsSketches->getSketchesSearch($_GET['term']));
		break;
		case 'getTaskContext':
			echo($projectsSketches->getTaskContext($_GET['id'],$_GET['field']));
		break;
		case 'saveLastUsedSketches':
			echo($projectsSketches->saveLastUsedSketches($_GET['id']));
		break;
		case 'rotateImage':
			echo($projectsSketches->rotateImage($_GET['img']));
		break;
		
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			$canvasList_id = array();
			$canvasList_text = array();
			$canvasList = array();
			
			if(isset($_POST['canvasList_id'])) {
				$canvasList_id = $_POST['canvasList_id'];
				$canvasList_text_orig = $_POST['canvasList_text'];
				$canvasList_text = "";
				foreach ($canvasList_text_orig as $key => $canvasList) {
					$canvasList_new = $system->checkMagicQuotes($canvasList);
					$canvasList_text[$key] = $canvasList_new;
				}
			}
			
			$task_id = array();
			//$task_title = array();
			$task_text = array();
			$task_date = array();
			$task_sketchtype = array();
			
			$task = array();
			
			if(isset($_POST['task_id'])) {
				$task_id = $_POST['task_id'];
				//$task_title = $_POST['task_title'];
				//$task_title_orig = $_POST['task_title'];
				//$task_title = "";
				/*foreach ($task_title_orig as $key => $text) {
					$text_new = $system->checkMagicQuotes($text);
					$task_title[$key] = $text_new;
				}*/
				$task_text_orig = $_POST['task_text'];
				$task_text = "";
				foreach ($task_text_orig as $key => $text) {
					$text_new = $system->checkMagicQuotes($text);
					$task_text[$key] = $text_new;
				}
				$task_date = $_POST['task_date'];
				//$sketches_task_team = $_POST['sketches_task_team'];
				//$sketches_task_team_ct = '';
				$task_sketchtype = $_POST['task_sketchtype'];
				//$task_place = $_POST['task_place'];
				//$task_time = $_POST['task_time'];
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			if(isset($_POST['task_sort'])) {
				$task_sort = $_POST['task_sort'];
			}
			echo($projectsSketches->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']),$canvasList_id,$canvasList_text,$_POST['sketch_access'],$_POST['sketch_access_orig']));
		break;
		case 'sendDetails':
			echo($projectsSketches->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($projectsSketches->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
		case 'saveDrawing':
			echo($projectsSketches->saveDrawing($_POST['id'],$_POST['img']));
		break;
	}
}

?>