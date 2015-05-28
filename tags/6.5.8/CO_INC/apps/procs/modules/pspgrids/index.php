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


// Pspgrids
include_once(CO_INC . "/apps/procs/modules/pspgrids/config.php");
include_once(CO_INC . "/apps/procs/modules/pspgrids/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/pspgrids/model.php");
include_once(CO_INC . "/apps/procs/modules/pspgrids/controller.php");
$procsPspgrids = new ProcsPspgrids("pspgrids");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getCoPopup':
			echo($procsPspgrids->getCoPopup());
		break;
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			$fid = 0;
			if(!empty($_GET['fid'])) {
				$fid = $_GET['fid'];
			}
			echo($procsPspgrids->getList($_GET['id'],$sort,$fid));
		break;
		case 'getDetails':
			echo($procsPspgrids->getDetails($_GET['id'],$_GET['fid']));
		break;
		case 'createNew':
			echo($procsPspgrids->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($procsPspgrids->createDuplicate($_GET['id']));
		break;
		case 'binPspgrid':
			echo($procsPspgrids->binPspgrid($_GET['id']));
		break;
		case 'restorePspgrid':
			echo($procsPspgrids->restorePspgrid($_GET['id']));
		break;
			case 'deletePspgrid':
			echo($procsPspgrids->deletePspgrid($_GET['id']));
		break;
		case 'restorePspgridColumn':
			echo($procsPspgrids->restorePspgridColumn($_GET['id']));
		break;
			case 'deletePspgridColumn':
			echo($procsPspgrids->deletePspgridColumn($_GET['id']));
		break;
		case 'setOrder':
			echo($procs->setSortOrder("procs-pspgrids-sort",$_GET['pspgridItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procsPspgrids->printDetails($_GET['id'],$t,$_GET['option']));
		break;
		case 'getSend':
			echo($procsPspgrids->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($procsPspgrids->getSendtoDetails("procs_pspgrids",$_GET['id']));
		break;
		case 'getPrintOptions':
			echo($procsPspgrids->getPrintOptions());
		break;
		/*case 'getSendToOptions':
			echo($procsPspgrids->getSendToOptions());
		break;*/
		case 'checkinPspgrid':
			echo($procsPspgrids->checkinPspgrid($_GET['id']));
		break;
		case 'toggleIntern':
			echo($procsPspgrids->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($procsPspgrids->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($procsPspgrids->deleteTask($_GET['id']));
		break;
		case 'restorePspgridTask':
			echo($procsPspgrids->restorePspgridTask($_GET['id']));
		break;
			case 'deletePspgridTask':
			echo($procsPspgrids->deletePspgridTask($_GET['id']));
		break;
		case 'getPspgridStatusDialog':
			echo($procsPspgrids->getPspgridStatusDialog());
		break;
		case 'savePspgridColumns':
			echo($procsPspgrids->savePspgridColumns($_GET['pspgridscol']));
		break;
		case 'savePspgridColDays':
			echo($procsPspgrids->savePspgridColDays($_GET['id'],$_GET['days']));
		break;
		case 'newPspgridColumn':
			echo($procsPspgrids->newPspgridColumn($_GET['id'],$_GET['sort']));
		break;
		case 'binPspgridColumn':
			echo($procsPspgrids->binPspgridColumn($_GET['id']));
		break;
		case 'savePspgridItems':
			$item = ""; // options: pdf, html
			if(!empty($_GET['procspspgriditem'])) {
				$item = $_GET['procspspgriditem'];
			}
			echo($procsPspgrids->savePspgridItems($_GET["col"],$item));
		break;
		case 'getPspgridNote':
			echo($procsPspgrids->getPspgridNote($_GET["id"]));
		break;
		case 'savePspgridNewNote':
			echo($procsPspgrids->savePspgridNewNote($_GET["pid"],$_GET["id"]));
		break;
		case 'savePspgridNoteTitle':
			echo($procsPspgrids->savePspgridNoteTitle($_GET["id"],$_GET["col"]));
		break;
		case 'savePspgridNewNoteTitle':
			echo($procsPspgrids->savePspgridNewNoteTitle($_GET["pid"],$_GET["id"],$_GET["col"]));
		break;
		case 'savePspgridNewManualNote':
			echo($procsPspgrids->savePspgridNewManualNote($_GET["pid"]));
		break;
		case 'savePspgridNewManualTitle':
			echo($procsPspgrids->savePspgridNewManualTitle($_GET["pid"],$_GET["col"]));
		break;
		case 'binItem':
			echo($procsPspgrids->binItem($_GET['id']));
		break;
		case 'setItemStatus':
			echo($procsPspgrids->setItemStatus($_GET['proc_id'],$_GET['id'],$_GET["status"]));
		break;
		case 'setItemType':
			echo($procsPspgrids->setItemType($_GET['id'],$_GET["type"]));
		break;
		case 'convertToProject':
			echo($procsPspgrids->convertToProject($_GET['id'],$_GET['kickoff'],$_GET['folder'],$system->checkMagicQuotes($_GET['protocol'])));
		break;
		case 'getHelp':
			echo($procsPspgrids->getHelp());
		break;
		case 'toggleCurrency':
			echo($procsPspgrids->toggleCurrency($_GET['id'],$_GET['cur']));
		break;

	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($procsPspgrids->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['owner']), $system->checkMagicQuotes($_POST['owner_ct']), $system->checkMagicQuotes($_POST['management']), $system->checkMagicQuotes($_POST['management_ct']), $system->checkMagicQuotes($_POST['team']), $system->checkMagicQuotes($_POST['team_ct']),$_POST['pspgrid_access'],$_POST['pspgrid_access_orig']));
		break;
		case 'sendDetails':
			echo($procsPspgrids->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'savePspgridNote':
			echo($procsPspgrids->savePspgridNote($_POST["proc_id"],$_POST["id"],$system->checkMagicQuotes($_POST['title']), $_POST['team'],$system->checkMagicQuotes($_POST['team_ct']),htmlspecialchars($_POST['text']),$_POST['days'],$_POST['costs_employees'],$_POST['costs_materials'],$_POST['costs_external'],$_POST['costs_other']));
		break;
	}
}

?>