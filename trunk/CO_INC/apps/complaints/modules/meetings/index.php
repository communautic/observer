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
//include_once(CO_INC . "/apps/complaints/modules/phases/config.php");
//include_once(CO_INC . "/apps/complaints/modules/phases/model.php");
//include_once(CO_INC . "/apps/complaints/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/complaints/modules/documents/config.php");
include_once(CO_INC . "/apps/complaints/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/complaints/modules/documents/model.php");
include_once(CO_INC . "/apps/complaints/modules/documents/controller.php");


// Meetings
include_once(CO_INC . "/apps/complaints/modules/meetings/config.php");
include_once(CO_INC . "/apps/complaints/modules/meetings/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/complaints/modules/meetings/model.php");
include_once(CO_INC . "/apps/complaints/modules/meetings/controller.php");
$complaintsMeetings = new ComplaintsMeetings("meetings");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($complaintsMeetings->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($complaintsMeetings->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($complaintsMeetings->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($complaintsMeetings->createDuplicate($_GET['id']));
		break;
		case 'binMeeting':
			echo($complaintsMeetings->binMeeting($_GET['id']));
		break;
		case 'restoreMeeting':
			echo($complaintsMeetings->restoreMeeting($_GET['id']));
		break;
			case 'deleteMeeting':
			echo($complaintsMeetings->deleteMeeting($_GET['id']));
		break;
		case 'setOrder':
			echo($complaints->setSortOrder("complaints-meetings-sort",$_GET['meetingItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($complaintsMeetings->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($complaintsMeetings->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($complaintsMeetings->getSendtoDetails("complaints_meetings",$_GET['id']));
		break;
		case 'checkinMeeting':
			echo($complaintsMeetings->checkinMeeting($_GET['id']));
		break;
		case 'toggleIntern':
			echo($complaintsMeetings->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($complaintsMeetings->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($complaintsMeetings->deleteTask($_GET['id']));
		break;
		case 'sortItems':
			echo($complaintsMeetings->sortItems($_GET['task']));
		break;
		case 'restoreMeetingTask':
			echo($complaintsMeetings->restoreMeetingTask($_GET['id']));
		break;
			case 'deleteMeetingTask':
			echo($complaintsMeetings->deleteMeetingTask($_GET['id']));
		break;
		case 'getMeetingStatusDialog':
			echo($complaintsMeetings->getMeetingStatusDialog());
		break;
		case 'getHelp':
			echo($complaintsMeetings->getHelp());
		break;
		case 'newCheckpoint':
			echo($complaintsMeetings->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($complaintsMeetings->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($complaintsMeetings->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($complaintsMeetings->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
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
			echo($complaintsMeetings->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['meetingstart'], $_POST['meetingend'], $_POST['location'], $system->checkMagicQuotes($_POST['location_ct']), $_POST['participants'], $system->checkMagicQuotes($_POST['participants_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$task_id,$task_title,$task_text,$task,$task_sort,$_POST['documents'],$_POST['meeting_access'],$_POST['meeting_access_orig']));
		break;
		case 'sendDetails':
			echo($complaintsMeetings->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($complaintsMeetings->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>