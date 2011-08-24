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
include_once(CO_INC . "/apps/projects/modules/phases/config.php");
/*include_once(CO_INC . "/apps/brainstorms/modules/phases/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/phases/controller.php");*/
					
// get dependend module documents
include_once(CO_INC . "/apps/brainstorms/modules/documents/config.php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/documents/controller.php");


// Rosters
include_once(CO_INC . "/apps/brainstorms/modules/rosters/config.php");
include_once(CO_INC . "/apps/brainstorms/modules/rosters/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/brainstorms/modules/rosters/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/rosters/controller.php");
$brainstormsRosters = new BrainstormsRosters("rosters");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($brainstormsRosters->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($brainstormsRosters->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($brainstormsRosters->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($brainstormsRosters->createDuplicate($_GET['id']));
		break;
		case 'binRoster':
			echo($brainstormsRosters->binRoster($_GET['id']));
		break;
		case 'restoreRoster':
			echo($brainstormsRosters->restoreRoster($_GET['id']));
		break;
			case 'deleteRoster':
			echo($brainstormsRosters->deleteRoster($_GET['id']));
		break;
		case 'setOrder':
			echo($brainstorms->setSortOrder("roster-sort",$_GET['rosterItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstormsRosters->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($brainstormsRosters->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($brainstormsRosters->getSendtoDetails("rosters",$_GET['id']));
		break;
		case 'checkinRoster':
			echo($brainstormsRosters->checkinRoster($_GET['id']));
		break;
		case 'toggleIntern':
			echo($brainstormsRosters->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($brainstormsRosters->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($brainstormsRosters->deleteTask($_GET['id']));
		break;
		case 'restoreRosterTask':
			echo($brainstormsRosters->restoreRosterTask($_GET['id']));
		break;
			case 'deleteRosterTask':
			echo($brainstormsRosters->deleteRosterTask($_GET['id']));
		break;
		case 'getRosterStatusDialog':
			echo($brainstormsRosters->getRosterStatusDialog());
		break;
		case 'saveRosterColumns':
			echo($brainstormsRosters->saveRosterColumns($_GET['brainstormscol']));
		break;
		case 'newRosterColumn':
			echo($brainstormsRosters->newRosterColumn($_GET['id'],$_GET['sort']));
		break;
		case 'deleteRosterColumn':
			echo($brainstormsRosters->deleteRosterColumn($_GET['id']));
		break;
		case 'saveRosterItems':
			echo($brainstormsRosters->saveRosterItems($_GET["col"],$_GET['item']));
		break;
		case 'getRosterNote':
			echo($brainstormsRosters->getRosterNote($_GET["id"]));
		break;
		case 'saveRosterNewNote':
			echo($brainstormsRosters->saveRosterNewNote($_GET["pid"],$_GET["id"]));
		break;
		case 'saveRosterNewManualNote':
			echo($brainstormsRosters->saveRosterNewManualNote($_GET["pid"]));
		break;
		case 'toggleMilestone':
			echo($brainstormsRosters->toggleMilestone($_GET['id'],$_GET['ms']));
		break;
		case 'binItem':
			echo($brainstormsRosters->binItem($_GET['id']));
		break;
		case 'convertToProject':
			echo($brainstormsRosters->convertToProject($_GET['id'],$_GET['kickoff'],$_GET['folder'],$_GET['protocol']));
		break;

	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($brainstormsRosters->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title'])));
		break;
		case 'sendDetails':
			echo($brainstormsRosters->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'saveRosterNote':
			echo($brainstormsRosters->saveRosterNote($_POST["id"],$system->checkMagicQuotes($_POST['title']),$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>