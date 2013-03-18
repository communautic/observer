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
//include_once(CO_INC . "/apps/trainings/modules/phases/config.php");
//include_once(CO_INC . "/apps/trainings/modules/phases/model.php");
//include_once(CO_INC . "/apps/trainings/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/trainings/modules/documents/config.php");
include_once(CO_INC . "/apps/trainings/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/trainings/modules/documents/model.php");
include_once(CO_INC . "/apps/trainings/modules/documents/controller.php");


// Meetings
include_once(CO_INC . "/apps/trainings/modules/meetings/config.php");
include_once(CO_INC . "/apps/trainings/modules/meetings/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/trainings/modules/meetings/model.php");
include_once(CO_INC . "/apps/trainings/modules/meetings/controller.php");
$trainingsMeetings = new TrainingsMeetings("meetings");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainingsMeetings->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($trainingsMeetings->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($trainingsMeetings->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($trainingsMeetings->createDuplicate($_GET['id']));
		break;
		case 'binMeeting':
			echo($trainingsMeetings->binMeeting($_GET['id']));
		break;
		case 'restoreMeeting':
			echo($trainingsMeetings->restoreMeeting($_GET['id']));
		break;
			case 'deleteMeeting':
			echo($trainingsMeetings->deleteMeeting($_GET['id']));
		break;
		case 'setOrder':
			echo($trainings->setSortOrder("trainings-meetings-sort",$_GET['meetingItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($trainingsMeetings->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($trainingsMeetings->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($trainingsMeetings->getSendtoDetails("trainings_meetings",$_GET['id']));
		break;
		case 'checkinMeeting':
			echo($trainingsMeetings->checkinMeeting($_GET['id']));
		break;
		case 'toggleIntern':
			echo($trainingsMeetings->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($trainingsMeetings->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($trainingsMeetings->deleteTask($_GET['id']));
		break;
		case 'sortItems':
			echo($trainingsMeetings->sortItems($_GET['task']));
		break;
		case 'restoreMeetingTask':
			echo($trainingsMeetings->restoreMeetingTask($_GET['id']));
		break;
			case 'deleteMeetingTask':
			echo($trainingsMeetings->deleteMeetingTask($_GET['id']));
		break;
		case 'getMeetingStatusDialog':
			echo($trainingsMeetings->getMeetingStatusDialog());
		break;
		case 'getHelp':
			echo($trainingsMeetings->getHelp());
		break;
		case 'newCheckpoint':
			echo($trainingsMeetings->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($trainingsMeetings->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($trainingsMeetings->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($trainingsMeetings->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getTrainingsDialog':
			echo($trainingsMeetings->getTrainingsDialog());
		break;
		case 'copyMeeting':
			echo($trainingsMeetings->copyMeeting($_GET['pid'],$_GET['phid']));
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
			echo($trainingsMeetings->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['meetingstart'], $_POST['meetingend'], $_POST['location'], $system->checkMagicQuotes($_POST['location_ct']), $_POST['participants'], $system->checkMagicQuotes($_POST['participants_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$task_id,$task_title,$task_text,$task,$task_sort,$_POST['documents'],$_POST['meeting_access'],$_POST['meeting_access_orig']));
		break;
		case 'sendDetails':
			echo($trainingsMeetings->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($trainingsMeetings->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>