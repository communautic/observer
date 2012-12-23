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


// Meetings
include_once(CO_INC . "/apps/employees/modules/meetings/config.php");
include_once(CO_INC . "/apps/employees/modules/meetings/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/meetings/model.php");
include_once(CO_INC . "/apps/employees/modules/meetings/controller.php");
$employeesMeetings = new EmployeesMeetings("meetings");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($employeesMeetings->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($employeesMeetings->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($employeesMeetings->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($employeesMeetings->createDuplicate($_GET['id']));
		break;
		case 'binMeeting':
			echo($employeesMeetings->binMeeting($_GET['id']));
		break;
		case 'restoreMeeting':
			echo($employeesMeetings->restoreMeeting($_GET['id']));
		break;
			case 'deleteMeeting':
			echo($employeesMeetings->deleteMeeting($_GET['id']));
		break;
		case 'setOrder':
			echo($employees->setSortOrder("employees-meetings-sort",$_GET['meetingItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employeesMeetings->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($employeesMeetings->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($employeesMeetings->getSendtoDetails("employees_meetings",$_GET['id']));
		break;
		case 'checkinMeeting':
			echo($employeesMeetings->checkinMeeting($_GET['id']));
		break;
		case 'toggleIntern':
			echo($employeesMeetings->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($employeesMeetings->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($employeesMeetings->deleteTask($_GET['id']));
		break;
		case 'sortItems':
			echo($employeesMeetings->sortItems($_GET['task']));
		break;
		case 'restoreMeetingTask':
			echo($employeesMeetings->restoreMeetingTask($_GET['id']));
		break;
			case 'deleteMeetingTask':
			echo($employeesMeetings->deleteMeetingTask($_GET['id']));
		break;
		case 'getMeetingStatusDialog':
			echo($employeesMeetings->getMeetingStatusDialog());
		break;
		case 'getHelp':
			echo($employeesMeetings->getHelp());
		break;
		case 'newCheckpoint':
			echo($employeesMeetings->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($employeesMeetings->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($employeesMeetings->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($employeesMeetings->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getEmployeesDialog':
			echo($employeesMeetings->getEmployeesDialog());
		break;
		case 'copyMeeting':
			echo($employeesMeetings->copyMeeting($_GET['pid'],$_GET['phid']));
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
			echo($employeesMeetings->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['meetingstart'], $_POST['meetingend'], $_POST['location'], $system->checkMagicQuotes($_POST['location_ct']), $_POST['participants'], $system->checkMagicQuotes($_POST['participants_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$task_id,$task_title,$task_text,$task,$task_sort,$_POST['documents'],$_POST['meeting_access'],$_POST['meeting_access_orig']));
		break;
		case 'sendDetails':
			echo($employeesMeetings->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($employeesMeetings->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>