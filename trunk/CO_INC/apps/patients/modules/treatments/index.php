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


// Treatments
include_once(CO_INC . "/apps/patients/modules/treatments/config.php");
include_once(CO_INC . "/apps/patients/modules/treatments/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/treatments/model.php");
include_once(CO_INC . "/apps/patients/modules/treatments/controller.php");
$patientsTreatments = new PatientsTreatments("treatments");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getCoPopup':
			echo($patientsTreatments->getCoPopup($_GET['id']));
		break;
		case 'generateBarzahlung':
			echo($patientsTreatments->generateBarzahlung($_GET['tid'],$_GET['tasks']));
		break;
		case 'deleteBarBeleg':
			echo($patientsTreatments->deleteBarBeleg($_GET['id']));
		break;
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsTreatments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsTreatments->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($patientsTreatments->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($patientsTreatments->createDuplicate($_GET['id']));
		break;
		case 'createDuplicateWithTreatments':
			echo($patientsTreatments->createDuplicateWithTreatments($_GET['id']));
		break;
		case 'binTreatment':
			echo($patientsTreatments->binTreatment($_GET['id']));
		break;
		case 'restoreTreatment':
			echo($patientsTreatments->restoreTreatment($_GET['id']));
		break;
			case 'deleteTreatment':
			echo($patientsTreatments->deleteTreatment($_GET['id']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-treatments-sort",$_GET['treatmentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsTreatments->printDetails($_GET['id'],$t,$_GET['option']));
		break;
		case 'getPrintOptions':
			echo($patientsTreatments->getPrintOptions());
		break;
		case 'getSendToOptions':
			echo($patientsTreatments->getSendToOptions());
		break;
		case 'getSend':
			echo($patientsTreatments->getSend($_GET['id'],$_GET['option']));
		break;
		case 'getSendtoDetails':
			echo($patientsTreatments->getSendtoDetails("patients_treatments",$_GET['id']));
		break;
		case 'checkinTreatment':
			echo($patientsTreatments->checkinTreatment($_GET['id']));
		break;
		case 'toggleIntern':
			echo($patientsTreatments->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($patientsTreatments->addTask($_GET['pid'],$_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($patientsTreatments->deleteTask($_GET['id']));
		break;
		case 'restoreTreatmentTask':
			echo($patientsTreatments->restoreTreatmentTask($_GET['id']));
		break;
			case 'deleteTreatmentTask':
			echo($patientsTreatments->deleteTreatmentTask($_GET['id']));
		break;
		case 'restoreTreatmentDiagnose':
			echo($patientsTreatments->restoreTreatmentDiagnose($_GET['id']));
		break;
			case 'deleteTreatmentDiagnose':
			echo($patientsTreatments->deleteTreatmentDiagnose($_GET['id']));
		break;
		case 'getTreatmentStatusDialog':
			echo($patientsTreatments->getTreatmentStatusDialog());
		break;
		case 'getTreatmentsTypeDialog':
			echo($patientsTreatments->getTreatmentsTypeDialog($_GET['field'],$_GET['append']));
		break;
		case 'getHelp':
			echo($patientsTreatments->getHelp());
		break;
		case 'newCheckpoint':
			echo($patientsTreatments->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($patientsTreatments->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($patientsTreatments->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($patientsTreatments->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		//diagnose
		case 'updatePosition':
			echo($patientsTreatments->updatePosition($_GET['id'],$_GET['x'],$_GET['y']));
		break;
		case 'addDiagnose':
			echo($patientsTreatments->addDiagnose($_GET['mid'],$_GET['num']));
		break;
		case 'binDiagnose':
			echo($patientsTreatments->binDiagnose($_GET['id']));
		break;
		case 'getTreatmentTypeMin':
			echo($patientsTreatments->getTreatmentTypeMin($_GET['id']));
		break;
		case 'getTreatmentsSearch':
			echo($patientsTreatments->getTreatmentsSearch($_GET['term']));
		break;
		case 'getTaskContext':
			echo($patientsTreatments->getTaskContext($_GET['id'],$_GET['field']));
		break;
		case 'saveLastUsedTreatments':
			echo($patientsTreatments->saveLastUsedTreatments($_GET['id']));
		break;
		case 'getTreatmentsMethodDialog':
			echo($patientsTreatments->getTreatmentsMethodDialog($_GET['field']));
		break;
		case 'getTreatmentInfoForCalendar':
			echo($patientsTreatments->getTreatmentInfoForCalendar($_GET['id']));
		break;
		case 'getMethodContext':
			echo($patientsTreatments->getMethodContext($_GET['id'],$_GET['field'],$_GET['edit']));
		break;
		case 'generateInvoice':
			echo($patientsTreatments->generateInvoice($_GET['id']));
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
			$task_treatmenttype = array();
			
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
				//$treatments_task_team = $_POST['treatments_task_team'];
				//$treatments_task_team_ct = '';
				$task_treatmenttype = $_POST['task_treatmenttype'];
				//$task_place = $_POST['task_place'];
				//$task_time = $_POST['task_time'];
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			if(isset($_POST['task_sort'])) {
				$task_sort = $_POST['task_sort'];
			}
			echo($patientsTreatments->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $system->checkMagicQuotes($_POST['protocol']),$_POST['method'],$system->checkMagicQuotes($_POST['protocol2']),$system->checkMagicQuotes($_POST['protocol3']), $_POST['discount'], $_POST['vat'], $_POST['doctor'], $system->checkMagicQuotes($_POST['doctor_ct']),$task_id,$task_date,$task_text,$task,$task_treatmenttype,$canvasList_id,$canvasList_text,$_POST['treatment_access'],$_POST['treatment_access_orig'],$_POST['documents']));
		break;
		case 'sendDetails':
			echo($patientsTreatments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($patientsTreatments->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
		case 'saveDrawing':
			echo($patientsTreatments->saveDrawing($_POST['id'],$_POST['img']));
		break;
	}
}

?>