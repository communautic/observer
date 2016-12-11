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


// Services
include_once(CO_INC . "/apps/patients/modules/services/config.php");
include_once(CO_INC . "/apps/patients/modules/services/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/services/model.php");
include_once(CO_INC . "/apps/patients/modules/services/controller.php");
$patientsServices = new PatientsServices("services");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsServices->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsServices->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($patientsServices->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($patientsServices->createDuplicate($_GET['id']));
		break;
		case 'binService':
			echo($patientsServices->binService($_GET['id']));
		break;
		case 'restoreService':
			echo($patientsServices->restoreService($_GET['id']));
		break;
			case 'deleteService':
			echo($patientsServices->deleteService($_GET['id']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-services-sort",$_GET['serviceItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsServices->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($patientsServices->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patientsServices->getSendtoDetails("patients_services",$_GET['id']));
		break;
		case 'checkinService':
			echo($patientsServices->checkinService($_GET['id']));
		break;
		case 'toggleIntern':
			echo($patientsServices->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($patientsServices->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($patientsServices->deleteTask($_GET['id']));
		break;
		case 'sortItems':
			echo($patientsServices->sortItems($_GET['task']));
		break;
		case 'restoreServiceTask':
			echo($patientsServices->restoreServiceTask($_GET['id']));
		break;
			case 'deleteServiceTask':
			echo($patientsServices->deleteServiceTask($_GET['id']));
		break;
		case 'getServiceStatusDialog':
			echo($patientsServices->getServiceStatusDialog());
		break;
		case 'getHelp':
			echo($patientsServices->getHelp());
		break;
		case 'newCheckpoint':
			echo($patientsServices->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($patientsServices->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($patientsServices->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($patientsServices->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getPatientsDialog':
			echo($patientsServices->getPatientsDialog());
		break;
		case 'copyService':
			echo($patientsServices->copyService($_GET['pid'],$_GET['phid']));
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
			$task_sort = array();
			
			if(isset($_POST['task_id'])) {
				$task_id = $_POST['task_id'];
				//$task_title = $_POST['task_title'];
				$task_title_orig = $_POST['task_title'];
				$task_title = "";
				foreach ($task_title_orig as $key => $text) {
					$text_new = $system->checkMagicQuotes($text);
					$task_title[$key] = $text_new;
				}
				//$task_text = $_POST['task_text'];
				/*$task_text_orig = $_POST['task_text'];
				$task_text = "";
				foreach ($task_text_orig as $key => $text) {
					$text_new = $system->checkMagicQuotes($text);
					$task_text[$key] = $text_new;
				}*/
				$task_text2_orig = $_POST['task_text2'];
				$task_text2 = "";
				foreach ($task_text2_orig as $key => $text) {
					$text2_new = $system->checkMagicQuotes($text);
					$task_text2[$key] = $text2_new;
				}
				$task_text3_orig = $_POST['task_text3'];
				$task_text3 = "";
				foreach ($task_text3_orig as $key => $text) {
					$text3_new = $system->checkMagicQuotes($text);
					$task_text3[$key] = $text3_new;
				}
			}
			if(isset($_POST['task'])) {
				$task = $_POST['task'];
			}
			if(isset($_POST['task_sort'])) {
				$task_sort = $_POST['task_sort'];
			}
			echo($patientsServices->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['discount'], $_POST['vat'],$task_id,$task_title,$task_text2,$task_text3,$task,$task_sort,$_POST['documents'],$_POST['service_access'],$_POST['service_access_orig']));
		break;
		case 'sendDetails':
			echo($patientsServices->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($patientsServices->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>