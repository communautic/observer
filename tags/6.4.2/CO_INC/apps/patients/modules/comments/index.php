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
					
// get dependend module documents
include_once(CO_INC . "/apps/patients/modules/documents/config.php");
include_once(CO_INC . "/apps/patients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/documents/model.php");
include_once(CO_INC . "/apps/patients/modules/documents/controller.php");


// Comments
include_once(CO_INC . "/apps/patients/modules/comments/config.php");
include_once(CO_INC . "/apps/patients/modules/comments/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/comments/model.php");
include_once(CO_INC . "/apps/patients/modules/comments/controller.php");
$patientsComments = new PatientsComments("comments");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsComments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsComments->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($patientsComments->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($patientsComments->createDuplicate($_GET['id']));
		break;
		case 'binComment':
			echo($patientsComments->binComment($_GET['id']));
		break;
		case 'restoreComment':
			echo($patientsComments->restoreComment($_GET['id']));
		break;
			case 'deleteComment':
			echo($patientsComments->deleteComment($_GET['id']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-comments-sort",$_GET['commentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsComments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($patientsComments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patientsComments->getSendtoDetails("patients_comments",$_GET['id']));
		break;
		case 'checkinComment':
			echo($patientsComments->checkinComment($_GET['id']));
		break;
		case 'toggleIntern':
			echo($patientsComments->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getCommentStatusDialog':
			echo($patientsComments->getCommentStatusDialog());
		break;
		case 'getHelp':
			echo($patientsComments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($patientsComments->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['comment_access'],$_POST['comment_access_orig']));
		break;
		case 'sendDetails':
			echo($patientsComments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>