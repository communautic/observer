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
include_once(CO_INC . "/apps/employees/modules/documents/config.php");
include_once(CO_INC . "/apps/employees/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/documents/model.php");
include_once(CO_INC . "/apps/employees/modules/documents/controller.php");


// Comments
include_once(CO_INC . "/apps/employees/modules/comments/config.php");
include_once(CO_INC . "/apps/employees/modules/comments/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/comments/model.php");
include_once(CO_INC . "/apps/employees/modules/comments/controller.php");
$employeesComments = new EmployeesComments("comments");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($employeesComments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($employeesComments->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($employeesComments->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($employeesComments->createDuplicate($_GET['id']));
		break;
		case 'binComment':
			echo($employeesComments->binComment($_GET['id']));
		break;
		case 'restoreComment':
			echo($employeesComments->restoreComment($_GET['id']));
		break;
			case 'deleteComment':
			echo($employeesComments->deleteComment($_GET['id']));
		break;
		case 'setOrder':
			echo($employees->setSortOrder("employees-comments-sort",$_GET['commentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employeesComments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($employeesComments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($employeesComments->getSendtoDetails("employees_comments",$_GET['id']));
		break;
		case 'checkinComment':
			echo($employeesComments->checkinComment($_GET['id']));
		break;
		case 'toggleIntern':
			echo($employeesComments->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getCommentStatusDialog':
			echo($employeesComments->getCommentStatusDialog());
		break;
		case 'getHelp':
			echo($employeesComments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($employeesComments->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['comment_access'],$_POST['comment_access_orig']));
		break;
		case 'sendDetails':
			echo($employeesComments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>