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
/*include_once(CO_INC . "/apps/complaints/modules/phases/model.php");
include_once(CO_INC . "/apps/complaints/modules/phases/controller.php");*/
					
// get dependend module documents
include_once(CO_INC . "/apps/complaints/modules/documents/config.php");
include_once(CO_INC . "/apps/complaints/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/complaints/modules/documents/model.php");
include_once(CO_INC . "/apps/complaints/modules/documents/controller.php");


// Grids
include_once(CO_INC . "/apps/complaints/modules/grids/config.php");
include_once(CO_INC . "/apps/complaints/modules/grids/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/complaints/modules/grids/model.php");
include_once(CO_INC . "/apps/complaints/modules/grids/controller.php");
$complaintsGrids = new ComplaintsGrids("grids");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($complaintsGrids->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($complaintsGrids->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($complaintsGrids->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($complaintsGrids->createDuplicate($_GET['id']));
		break;
		case 'binGrid':
			echo($complaintsGrids->binGrid($_GET['id']));
		break;
		case 'restoreGrid':
			echo($complaintsGrids->restoreGrid($_GET['id']));
		break;
			case 'deleteGrid':
			echo($complaintsGrids->deleteGrid($_GET['id']));
		break;
		case 'restoreGridColumn':
			echo($complaintsGrids->restoreGridColumn($_GET['id']));
		break;
			case 'deleteGridColumn':
			echo($complaintsGrids->deleteGridColumn($_GET['id']));
		break;
		case 'setOrder':
			echo($complaints->setSortOrder("complaints-grids-sort",$_GET['gridItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($complaintsGrids->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($complaintsGrids->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($complaintsGrids->getSendtoDetails("complaints_grids",$_GET['id']));
		break;
		case 'checkinGrid':
			echo($complaintsGrids->checkinGrid($_GET['id']));
		break;
		case 'toggleIntern':
			echo($complaintsGrids->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($complaintsGrids->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($complaintsGrids->deleteTask($_GET['id']));
		break;
		case 'restoreGridTask':
			echo($complaintsGrids->restoreGridTask($_GET['id']));
		break;
			case 'deleteGridTask':
			echo($complaintsGrids->deleteGridTask($_GET['id']));
		break;
		case 'getGridStatusDialog':
			echo($complaintsGrids->getGridStatusDialog());
		break;
		case 'saveGridColumns':
			echo($complaintsGrids->saveGridColumns($_GET['gridscol']));
		break;
		case 'saveGridColDays':
			echo($complaintsGrids->saveGridColDays($_GET['id'],$_GET['days']));
		break;
		case 'newGridColumn':
			echo($complaintsGrids->newGridColumn($_GET['id'],$_GET['sort']));
		break;
		case 'binGridColumn':
			echo($complaintsGrids->binGridColumn($_GET['id']));
		break;
		case 'saveGridItems':
			$item = ""; // options: pdf, html
			if(!empty($_GET['item'])) {
				$item = $_GET['item'];
			}
			echo($complaintsGrids->saveGridItems($_GET["col"],$item));
		break;
		case 'getGridNote':
			echo($complaintsGrids->getGridNote($_GET["id"]));
		break;
		case 'saveGridNewNote':
			echo($complaintsGrids->saveGridNewNote($_GET["pid"],$_GET["id"]));
		break;
		case 'saveGridNoteTitle':
			echo($complaintsGrids->saveGridNoteTitle($_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNoteStagegate':
			echo($complaintsGrids->saveGridNoteStagegate($_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewNoteTitle':
			echo($complaintsGrids->saveGridNewNoteTitle($_GET["pid"],$_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewNoteStagegate':
			echo($complaintsGrids->saveGridNewNoteStagegate($_GET["pid"],$_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewManualNote':
			echo($complaintsGrids->saveGridNewManualNote($_GET["pid"]));
		break;
		case 'saveGridNewManualTitle':
			echo($complaintsGrids->saveGridNewManualTitle($_GET["pid"],$_GET["col"]));
		break;
		case 'saveGridNewManualStagegate':
			echo($complaintsGrids->saveGridNewManualStagegate($_GET["pid"],$_GET["col"]));
		break;
		/*case 'toggleMilestone':
			echo($complaintsGrids->toggleMilestone($_GET['id'],$_GET['ms']));
		break;*/
		case 'binItem':
			echo($complaintsGrids->binItem($_GET['id']));
		break;
		case 'setItemStatus':
			echo($complaintsGrids->setItemStatus($_GET['id'],$_GET["status"]));
		break;
		case 'convertToProject':
			echo($complaintsGrids->convertToProject($_GET['id'],$_GET['kickoff'],$_GET['folder'],$system->checkMagicQuotes($_GET['protocol'])));
		break;
		case 'getHelp':
			echo($complaintsGrids->getHelp());
		break;

	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($complaintsGrids->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['owner']), $system->checkMagicQuotes($_POST['owner_ct']), $system->checkMagicQuotes($_POST['management']), $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['team']), $system->checkMagicQuotes($_POST['team_ct']),$_POST['grid_access'],$_POST['grid_access_orig']));
		break;
		case 'sendDetails':
			echo($complaintsGrids->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'saveGridNote':
			echo($complaintsGrids->saveGridNote($_POST["id"],$system->checkMagicQuotes($_POST['title']),$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>