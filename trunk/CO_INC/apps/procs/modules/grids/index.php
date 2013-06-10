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
/*include_once(CO_INC . "/apps/procs/modules/phases/model.php");
include_once(CO_INC . "/apps/procs/modules/phases/controller.php");*/
					
// get dependend module documents
include_once(CO_INC . "/apps/procs/modules/documents/config.php");
include_once(CO_INC . "/apps/procs/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/documents/model.php");
include_once(CO_INC . "/apps/procs/modules/documents/controller.php");


// Grids
include_once(CO_INC . "/apps/procs/modules/grids/config.php");
include_once(CO_INC . "/apps/procs/modules/grids/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/grids/model.php");
include_once(CO_INC . "/apps/procs/modules/grids/controller.php");
$procsGrids = new ProcsGrids("grids");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getCoPopup':
			echo($procsGrids->getCoPopup());
		break;
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($procsGrids->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($procsGrids->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($procsGrids->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($procsGrids->createDuplicate($_GET['id']));
		break;
		case 'binGrid':
			echo($procsGrids->binGrid($_GET['id']));
		break;
		case 'restoreGrid':
			echo($procsGrids->restoreGrid($_GET['id']));
		break;
			case 'deleteGrid':
			echo($procsGrids->deleteGrid($_GET['id']));
		break;
		case 'restoreGridColumn':
			echo($procsGrids->restoreGridColumn($_GET['id']));
		break;
			case 'deleteGridColumn':
			echo($procsGrids->deleteGridColumn($_GET['id']));
		break;
		case 'setOrder':
			echo($procs->setSortOrder("procs-grids-sort",$_GET['gridItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procsGrids->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($procsGrids->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($procsGrids->getSendtoDetails("procs_grids",$_GET['id']));
		break;
		case 'checkinGrid':
			echo($procsGrids->checkinGrid($_GET['id']));
		break;
		case 'toggleIntern':
			echo($procsGrids->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($procsGrids->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($procsGrids->deleteTask($_GET['id']));
		break;
		case 'restoreGridTask':
			echo($procsGrids->restoreGridTask($_GET['id']));
		break;
			case 'deleteGridTask':
			echo($procsGrids->deleteGridTask($_GET['id']));
		break;
		case 'getGridStatusDialog':
			echo($procsGrids->getGridStatusDialog());
		break;
		case 'saveGridColumns':
			echo($procsGrids->saveGridColumns($_GET['gridscol']));
		break;
		case 'saveGridColDays':
			echo($procsGrids->saveGridColDays($_GET['id'],$_GET['days']));
		break;
		case 'newGridColumn':
			echo($procsGrids->newGridColumn($_GET['id'],$_GET['sort']));
		break;
		case 'binGridColumn':
			echo($procsGrids->binGridColumn($_GET['id']));
		break;
		case 'saveGridItems':
			$item = ""; // options: pdf, html
			if(!empty($_GET['procsgriditem'])) {
				$item = $_GET['procsgriditem'];
			}
			echo($procsGrids->saveGridItems($_GET["col"],$item));
		break;
		case 'getGridNote':
			echo($procsGrids->getGridNote($_GET["id"]));
		break;
		case 'saveGridNewNote':
			echo($procsGrids->saveGridNewNote($_GET["pid"],$_GET["id"]));
		break;
		case 'saveGridNoteTitle':
			echo($procsGrids->saveGridNoteTitle($_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNoteStagegate':
			echo($procsGrids->saveGridNoteStagegate($_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewNoteTitle':
			echo($procsGrids->saveGridNewNoteTitle($_GET["pid"],$_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewNoteStagegate':
			echo($procsGrids->saveGridNewNoteStagegate($_GET["pid"],$_GET["id"],$_GET["col"]));
		break;
		case 'saveGridNewManualNote':
			echo($procsGrids->saveGridNewManualNote($_GET["pid"]));
		break;
		case 'saveGridNewManualTitle':
			echo($procsGrids->saveGridNewManualTitle($_GET["pid"],$_GET["col"]));
		break;
		case 'saveGridNewManualStagegate':
			echo($procsGrids->saveGridNewManualStagegate($_GET["pid"],$_GET["col"]));
		break;
		/*case 'toggleMilestone':
			echo($procsGrids->toggleMilestone($_GET['id'],$_GET['ms']));
		break;*/
		case 'binItem':
			echo($procsGrids->binItem($_GET['id']));
		break;
		case 'setItemStatus':
			echo($procsGrids->setItemStatus($_GET['id'],$_GET["status"]));
		break;
		case 'convertToProject':
			echo($procsGrids->convertToProject($_GET['id'],$_GET['kickoff'],$_GET['folder'],$system->checkMagicQuotes($_GET['protocol'])));
		break;
		case 'getHelp':
			echo($procsGrids->getHelp());
		break;
		case 'toggleCurrency':
			echo($procsGrids->toggleCurrency($_GET['id'],$_GET['cur']));
		break;

	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($procsGrids->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['owner']), $system->checkMagicQuotes($_POST['owner_ct']), $system->checkMagicQuotes($_POST['management']), $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['team']), $system->checkMagicQuotes($_POST['team_ct']),$_POST['grid_access'],$_POST['grid_access_orig']));
		break;
		case 'sendDetails':
			echo($procsGrids->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'saveGridNote':
			echo($procsGrids->saveGridNote($_POST["id"],$system->checkMagicQuotes($_POST['title']), $_POST['team'],$system->checkMagicQuotes($_POST['team_ct']),$system->checkMagicQuotes($_POST['text']),$_POST['hours'],$_POST['costs_employees'],$_POST['costs_materials'],$_POST['costs_external'],$_POST['costs_other']));
		break;
	}
}

?>