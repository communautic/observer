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


// Grids
include_once(CO_INC . "/apps/brainstorms/modules/grids/config.php");
include_once(CO_INC . "/apps/brainstorms/modules/grids/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/brainstorms/modules/grids/model.php");
include_once(CO_INC . "/apps/brainstorms/modules/grids/controller.php");
$brainstormsGrids = new BrainstormsGrids("grids");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($brainstormsGrids->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($brainstormsGrids->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($brainstormsGrids->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($brainstormsGrids->createDuplicate($_GET['id']));
		break;
		case 'binGrid':
			echo($brainstormsGrids->binGrid($_GET['id']));
		break;
		case 'restoreGrid':
			echo($brainstormsGrids->restoreGrid($_GET['id']));
		break;
			case 'deleteGrid':
			echo($brainstormsGrids->deleteGrid($_GET['id']));
		break;
		case 'restoreGridColumn':
			echo($brainstormsGrids->restoreGridColumn($_GET['id']));
		break;
			case 'deleteGridColumn':
			echo($brainstormsGrids->deleteGridColumn($_GET['id']));
		break;
		case 'setOrder':
			echo($brainstorms->setSortOrder("brainstorms-grids-sort",$_GET['gridItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($brainstormsGrids->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($brainstormsGrids->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($brainstormsGrids->getSendtoDetails("brainstorms_grids",$_GET['id']));
		break;
		case 'checkinGrid':
			echo($brainstormsGrids->checkinGrid($_GET['id']));
		break;
		case 'toggleIntern':
			echo($brainstormsGrids->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($brainstormsGrids->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($brainstormsGrids->deleteTask($_GET['id']));
		break;
		case 'restoreGridTask':
			echo($brainstormsGrids->restoreGridTask($_GET['id']));
		break;
			case 'deleteGridTask':
			echo($brainstormsGrids->deleteGridTask($_GET['id']));
		break;
		case 'getGridStatusDialog':
			echo($brainstormsGrids->getGridStatusDialog());
		break;
		case 'saveGridColumns':
			echo($brainstormsGrids->saveGridColumns($_GET['gridscol']));
		break;
		case 'saveGridColDays':
			echo($brainstormsGrids->saveGridColDays($_GET['id'],$_GET['days']));
		break;
		case 'newGridColumn':
			echo($brainstormsGrids->newGridColumn($_GET['id'],$_GET['sort']));
		break;
		case 'binGridColumn':
			echo($brainstormsGrids->binGridColumn($_GET['id']));
		break;
		case 'saveGridItems':
			$item = ""; // options: pdf, html
			if(!empty($_GET['item'])) {
				$item = $_GET['item'];
			}
			echo($brainstormsGrids->saveGridItems($_GET["col"],$item));
		break;
		case 'getGridNote':
			echo($brainstormsGrids->getGridNote($_GET["id"]));
		break;
		case 'saveGridNewNote':
			echo($brainstormsGrids->saveGridNewNote($_GET["pid"],$_GET["id"]));
		break;
		case 'saveGridNoteTitle':
			echo($brainstormsGrids->saveGridNoteTitle($_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNoteStagegate':
			echo($brainstormsGrids->saveGridNoteStagegate($_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewNoteTitle':
			echo($brainstormsGrids->saveGridNewNoteTitle($_GET["pid"],$_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewNoteStagegate':
			echo($brainstormsGrids->saveGridNewNoteStagegate($_GET["pid"],$_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewManualNote':
			echo($brainstormsGrids->saveGridNewManualNote($_GET["pid"]));
		break;
		case 'saveGridNewManualTitle':
			echo($brainstormsGrids->saveGridNewManualTitle($_GET["pid"],$_GET["col"]));
		break;
		case 'saveGridNewManualStagegate':
			echo($brainstormsGrids->saveGridNewManualStagegate($_GET["pid"],$_GET["col"]));
		break;
		case 'toggleMilestone':
			echo($brainstormsGrids->toggleMilestone($_GET['id'],$_GET['ms']));
		break;
		case 'binItem':
			echo($brainstormsGrids->binItem($_GET['id']));
		break;
		case 'setItemStatus':
			echo($brainstormsGrids->setItemStatus($_GET['id'],$_GET["status"]));
		break;
		case 'convertToProject':
			echo($brainstormsGrids->convertToProject($_GET['id'],$_GET['kickoff'],$_GET['folder'],$system->checkMagicQuotes($_GET['protocol'])));
		break;
		case 'getHelp':
			echo($brainstormsGrids->getHelp());
		break;

	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($brainstormsGrids->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['owner']), $system->checkMagicQuotes($_POST['owner_ct']), $system->checkMagicQuotes($_POST['management']), $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['team']), $system->checkMagicQuotes($_POST['team_ct']),$_POST['grid_access'],$_POST['grid_access_orig']));
		break;
		case 'sendDetails':
			echo($brainstormsGrids->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'saveGridNote':
			echo($brainstormsGrids->saveGridNote($_POST["id"],$system->checkMagicQuotes($_POST['title']),$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>