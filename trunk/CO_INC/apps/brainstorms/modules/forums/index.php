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

// get dependend modules
include_once(CO_INC . "/apps/brainstorms/modules/documents/config.php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/controller.php");

include_once(CO_INC . "/apps/brainstorms/modules/forums/config.php");
include_once(CO_INC . "/apps/brainstorms/modules/forums/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/brainstorms/modules/forums/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/forums/controller.php");

$brainstormsForums = new BrainstormsForums("forums");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($brainstormsForums->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			$view = "0";
			if(!empty($_GET['view'])) {
				$view = $_GET['view'];
			}
			echo($brainstormsForums->getDetails($_GET['id'],$view));
		break;
		case 'createNew':
			echo($brainstormsForums->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($brainstormsForums->createDuplicate($_GET['id']));
		break;
		case 'binForum':
			echo($brainstormsForums->binForum($_GET['id']));
		break;
		case 'restoreForum':
			echo($brainstormsForums->restoreForum($_GET['id']));
		break;
		case 'deleteForum':
			echo($brainstormsForums->deleteForum($_GET['id']));
		break;
		case 'setOrder':
			echo($brainstorms->setSortOrder("forum-sort",$_GET['forumItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstormsForums->printDetails($_GET['id'],$_GET['num'],$t));
		break;
		case 'getSend':
			echo($brainstormsForums->getSend($_GET['id'],$_GET['num']));
		break;
		case 'getSendtoDetails':
			echo($brainstormsForums->getSendtoDetails("brainstorms_forums",$_GET['id']));
		break;
		/*case 'checkinForum':
			echo($brainstormsForums->checkinForum($_GET['id']));
		break;*/
		case 'toggleIntern':
			echo($brainstormsForums->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getForumTaskDialog':
			echo($brainstormsForums->getForumTaskDialog());
		break;
		case 'getTasksDialog':
			echo($brainstormsForums->getTasksDialog($_GET['sql'],$_GET['field']));
		break;
		case 'getTaskDependencyExists':
			echo($brainstormsForums->getTaskDependencyExists($_GET['id']));
		break;
		case 'moveDependendTasks':
			echo($brainstormsForums->moveDependendTasks($_GET['id'],$_GET['days']));
		break;
		case 'binItem':
			echo($brainstormsForums->binItem($_GET['id']));
		break;
		case 'setItemStatus':
			echo($brainstormsForums->setItemStatus($_GET['id'],$_GET["status"]));
		break;
		case 'restoreForumTask':
			echo($brainstormsForums->restoreForumTask($_GET['id']));
		break;
		case 'deleteForumTask':
			echo($brainstormsForums->deleteForumTask($_GET['id']));
		break;
		case 'getForumStatusDialog':
			echo($brainstormsForums->getForumStatusDialog());
		break;
		case 'getHelp':
			echo($brainstormsForums->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($brainstormsForums->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['documents'],$_POST['forum_access'],$_POST['forum_access_orig'], $_POST['forum_status'], $_POST['forum_status_date']));
		break;
		case 'sendDetails':
			echo($brainstormsForums->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'addItem':
			echo($brainstormsForums->addItem($_POST['id'], $_POST['text'], $_POST['replyid'] , $_POST['num']));
		break;
	}
}

?>