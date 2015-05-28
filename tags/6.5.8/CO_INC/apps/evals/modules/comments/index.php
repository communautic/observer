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
include_once(CO_INC . "/apps/evals/modules/documents/config.php");
include_once(CO_INC . "/apps/evals/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/evals/modules/documents/model.php");
include_once(CO_INC . "/apps/evals/modules/documents/controller.php");


// Comments
include_once(CO_INC . "/apps/evals/modules/comments/config.php");
include_once(CO_INC . "/apps/evals/modules/comments/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/evals/modules/comments/model.php");
include_once(CO_INC . "/apps/evals/modules/comments/controller.php");
$evalsComments = new EvalsComments("comments");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($evalsComments->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($evalsComments->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($evalsComments->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($evalsComments->createDuplicate($_GET['id']));
		break;
		case 'binComment':
			echo($evalsComments->binComment($_GET['id']));
		break;
		case 'restoreComment':
			echo($evalsComments->restoreComment($_GET['id']));
		break;
			case 'deleteComment':
			echo($evalsComments->deleteComment($_GET['id']));
		break;
		case 'setOrder':
			echo($evals->setSortOrder("evals-comments-sort",$_GET['commentItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($evalsComments->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($evalsComments->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($evalsComments->getSendtoDetails("evals_comments",$_GET['id']));
		break;
		case 'checkinComment':
			echo($evalsComments->checkinComment($_GET['id']));
		break;
		case 'toggleIntern':
			echo($evalsComments->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getCommentStatusDialog':
			echo($evalsComments->getCommentStatusDialog());
		break;
		case 'getHelp':
			echo($evalsComments->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($evalsComments->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['comment_access'],$_POST['comment_access_orig']));
		break;
		case 'sendDetails':
			echo($evalsComments->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>