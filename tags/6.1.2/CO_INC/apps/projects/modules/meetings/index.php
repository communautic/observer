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


// Meetings
include_once(CO_INC . "/apps/projects/modules/meetings/config.php");
include_once(CO_INC . "/apps/projects/modules/meetings/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/meetings/model.php");
include_once(CO_INC . "/apps/projects/modules/meetings/controller.php");
$projectsMeetings = new ProjectsMeetings("meetings");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsMeetings->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($projectsMeetings->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($projectsMeetings->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($projectsMeetings->createDuplicate($_GET['id']));
		break;
		case 'binMeeting':
			echo($projectsMeetings->binMeeting($_GET['id']));
		break;
		case 'restoreMeeting':
			echo($projectsMeetings->restoreMeeting($_GET['id']));
		break;
			case 'deleteMeeting':
			echo($projectsMeetings->deleteMeeting($_GET['id']));
		break;
		case 'setOrder':
			echo($projects->setSortOrder("meeting-sort",$_GET['meetingItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($projectsMeetings->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($projectsMeetings->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($projectsMeetings->getSendtoDetails("projects_meetings",$_GET['id']));
		break;
		case 'checkinMeeting':
			echo($projectsMeetings->checkinMeeting($_GET['id']));
		break;
		case 'toggleIntern':
			echo($projectsMeetings->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($projectsMeetings->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($projectsMeetings->deleteTask($_GET['id']));
		break;
		case 'restoreMeetingTask':
			echo($projectsMeetings->restoreMeetingTask($_GET['id']));
		break;
			case 'deleteMeetingTask':
			echo($projectsMeetings->deleteMeetingTask($_GET['id']));
		break;
		case 'getMeetingStatusDialog':
			echo($projectsMeetings->getMeetingStatusDialog());
		break;
		case 'getHelp':
			echo($projectsMeetings->getHelp());
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
			echo($projectsMeetings->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['meetingstart'], $_POST['meetingend'], $_POST['location'], $system->checkMagicQuotes($_POST['location_ct']), $_POST['participants'], $system->checkMagicQuotes($_POST['participants_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$task_id,$task_title,$task_text,$task,$task_sort,$_POST['documents'],$_POST['meeting_access'],$_POST['meeting_access_orig'],$_POST['meeting_status'],$_POST['meeting_status_date']));
		break;
		case 'sendDetails':
			echo($projectsMeetings->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>