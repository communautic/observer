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


// Forums
include_once(CO_INC . "/apps/complaints/modules/forums/config.php");
include_once(CO_INC . "/apps/complaints/modules/forums/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/complaints/modules/forums/model.php");
include_once(CO_INC . "/apps/complaints/modules/forums/controller.php");
$complaintsForums = new ComplaintsForums("forums");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($complaintsForums->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($complaintsForums->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($complaintsForums->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($complaintsForums->createDuplicate($_GET['id']));
		break;
		case 'binForum':
			echo($complaintsForums->binForum($_GET['id']));
		break;
		case 'restoreForum':
			echo($complaintsForums->restoreForum($_GET['id']));
		break;
			case 'deleteForum':
			echo($complaintsForums->deleteForum($_GET['id']));
		break;
		case 'setOrder':
			echo($complaints->setSortOrder("complaints-forums-sort",$_GET['forumItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($complaintsForums->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($complaintsForums->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($complaintsForums->getSendtoDetails("complaints_forums",$_GET['id']));
		break;
		case 'setItemStatus':
			echo($complaintsForums->setItemStatus($_GET['id'],$_GET["status"]));
		break;
		case 'binItem':
			echo($complaintsForums->binItem($_GET['id']));
		break;
		case 'restoreItem':
			echo($complaintsForums->restoreItem($_GET['id']));
		break;
		case 'deleteItem':
			echo($complaintsForums->deleteItem($_GET['id']));
		break;
		case 'getForumStatusDialog':
			echo($complaintsForums->getForumStatusDialog());
		break;
		case 'getHelp':
			echo($complaintsForums->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($complaintsForums->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['forum_access'],$_POST['forum_access_orig'],$_POST['forum_status'],$_POST['forum_status_date']));
		break;
		case 'sendDetails':
			echo($complaintsForums->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'addItem':
			echo($complaintsForums->addItem($_POST['id'], $system->checkMagicQuotesTinyMCE($_POST['text']), $_POST['replyid'] , $_POST['num']));
		break;
	}
}

?>