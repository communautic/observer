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


// Meetings
include_once(CO_INC . "/apps/evals/modules/meetings/config.php");
include_once(CO_INC . "/apps/evals/modules/meetings/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/evals/modules/meetings/model.php");
include_once(CO_INC . "/apps/evals/modules/meetings/controller.php");
$evalsMeetings = new EvalsMeetings("meetings");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($evalsMeetings->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($evalsMeetings->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($evalsMeetings->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($evalsMeetings->createDuplicate($_GET['id']));
		break;
		case 'binMeeting':
			echo($evalsMeetings->binMeeting($_GET['id']));
		break;
		case 'restoreMeeting':
			echo($evalsMeetings->restoreMeeting($_GET['id']));
		break;
			case 'deleteMeeting':
			echo($evalsMeetings->deleteMeeting($_GET['id']));
		break;
		case 'setOrder':
			echo($evals->setSortOrder("evals-meetings-sort",$_GET['meetingItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evalsMeetings->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($evalsMeetings->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($evalsMeetings->getSendtoDetails("evals_meetings",$_GET['id']));
		break;
		case 'checkinMeeting':
			echo($evalsMeetings->checkinMeeting($_GET['id']));
		break;
		case 'toggleIntern':
			echo($evalsMeetings->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($evalsMeetings->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($evalsMeetings->deleteTask($_GET['id']));
		break;
		case 'sortItems':
			echo($evalsMeetings->sortItems($_GET['task']));
		break;
		case 'restoreMeetingTask':
			echo($evalsMeetings->restoreMeetingTask($_GET['id']));
		break;
			case 'deleteMeetingTask':
			echo($evalsMeetings->deleteMeetingTask($_GET['id']));
		break;
		case 'getMeetingStatusDialog':
			echo($evalsMeetings->getMeetingStatusDialog());
		break;
		case 'getHelp':
			echo($evalsMeetings->getHelp());
		break;
		case 'newCheckpoint':
			echo($evalsMeetings->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($evalsMeetings->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($evalsMeetings->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($evalsMeetings->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		case 'getEvalsDialog':
			echo($evalsMeetings->getEvalsDialog());
		break;
		case 'copyMeeting':
			echo($evalsMeetings->copyMeeting($_GET['pid'],$_GET['phid']));
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
			echo($evalsMeetings->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['meetingstart'], $_POST['meetingend'], $_POST['location'], $system->checkMagicQuotes($_POST['location_ct']), $_POST['participants'], $system->checkMagicQuotes($_POST['participants_ct']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$task_id,$task_title,$task_text,$task,$task_sort,$_POST['documents'],$_POST['meeting_access'],$_POST['meeting_access_orig']));
		break;
		case 'sendDetails':
			echo($evalsMeetings->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($evalsMeetings->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>