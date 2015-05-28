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
//include_once(CO_INC . "/apps/patients/modules/phases/config.php");
//include_once(CO_INC . "/apps/patients/modules/phases/model.php");
//include_once(CO_INC . "/apps/patients/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/patients/modules/documents/config.php");
include_once(CO_INC . "/apps/patients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/documents/model.php");
include_once(CO_INC . "/apps/patients/modules/documents/controller.php");


// Sketches
include_once(CO_INC . "/apps/patients/modules/sketches/config.php");
include_once(CO_INC . "/apps/patients/modules/sketches/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/sketches/model.php");
include_once(CO_INC . "/apps/patients/modules/sketches/controller.php");
$patientsSketches = new PatientsSketches("sketches");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsSketches->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsSketches->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($patientsSketches->createNew($_GET['id'],$_GET['type'],$_GET['image']));
		break;
		case 'getNewOptions':
			echo($patientsSketches->getNewOptions());
		break;
		case 'createNewImage':
			echo($patientsSketches->createNewImage($_GET['id']));
		break;
		case 'createDuplicate':
			echo($patientsSketches->createDuplicate($_GET['id']));
		break;
		case 'binSketch':
			echo($patientsSketches->binSketch($_GET['id']));
		break;
		case 'restoreSketch':
			echo($patientsSketches->restoreSketch($_GET['id']));
		break;
			case 'deleteSketch':
			echo($patientsSketches->deleteSketch($_GET['id']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-sketches-sort",$_GET['sketchItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsSketches->printDetails($_GET['id'],$t,$_GET['option']));
		break;
		case 'getPrintOptions':
			echo($patientsSketches->getPrintOptions());
		break;
		case 'getSendToOptions':
			echo($patientsSketches->getSendToOptions());
		break;
		case 'getSend':
			echo($patientsSketches->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patientsSketches->getSendtoDetails("patients_sketches",$_GET['id']));
		break;
		case 'checkinSketch':
			echo($patientsSketches->checkinSketch($_GET['id']));
		break;
		case 'toggleIntern':
			echo($patientsSketches->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($patientsSketches->addTask($_GET['pid'],$_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($patientsSketches->deleteTask($_GET['id']));
		break;
		case 'restoreSketchTask':
			echo($patientsSketches->restoreSketchTask($_GET['id']));
		break;
			case 'deleteSketchTask':
			echo($patientsSketches->deleteSketchTask($_GET['id']));
		break;
		case 'restoreSketchDiagnose':
			echo($patientsSketches->restoreSketchDiagnose($_GET['id']));
		break;
			case 'deleteSketchDiagnose':
			echo($patientsSketches->deleteSketchDiagnose($_GET['id']));
		break;
		case 'getSketchStatusDialog':
			echo($patientsSketches->getSketchStatusDialog());
		break;
		case 'getSketchesTypeDialog':
			echo($patientsSketches->getSketchesTypeDialog($_GET['field'],$_GET['append']));
		break;
		case 'getHelp':
			echo($patientsSketches->getHelp());
		break;
		case 'newCheckpoint':
			echo($patientsSketches->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($patientsSketches->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($patientsSketches->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($patientsSketches->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		//diagnose
		case 'updatePosition':
			echo($patientsSketches->updatePosition($_GET['id'],$_GET['x'],$_GET['y']));
		break;
		case 'addDiagnose':
			echo($patientsSketches->addDiagnose($_GET['mid'],$_GET['num']));
		break;
		case 'binDiagnose':
			echo($patientsSketches->binDiagnose($_GET['id']));
		break;
		case 'getSketchTypeMin':
			echo($patientsSketches->getSketchTypeMin($_GET['id']));
		break;
		case 'getSketchesSearch':
			echo($patientsSketches->getSketchesSearch($_GET['term']));
		break;
		case 'getTaskContext':
			echo($patientsSketches->getTaskContext($_GET['id'],$_GET['field']));
		break;
		case 'saveLastUsedSketches':
			echo($patientsSketches->saveLastUsedSketches($_GET['id']));
		break;
		case 'rotateImage':
			echo($patientsSketches->rotateImage($_GET['img']));
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
			echo($patientsSketches->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']),$canvasList_id,$canvasList_text,$_POST['sketch_access'],$_POST['sketch_access_orig']));
		break;
		case 'sendDetails':
			echo($patientsSketches->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($patientsSketches->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
		case 'saveDrawing':
			echo($patientsSketches->saveDrawing($_POST['id'],$_POST['img']));
		break;
	}
}

?>