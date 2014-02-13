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
//include_once(CO_INC . "/apps/procs/modules/phases/config.php");
//include_once(CO_INC . "/apps/procs/modules/phases/model.php");
//include_once(CO_INC . "/apps/procs/modules/phases/controller.php");
					
// get dependend module documents
include_once(CO_INC . "/apps/procs/modules/documents/config.php");
include_once(CO_INC . "/apps/procs/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/documents/model.php");
include_once(CO_INC . "/apps/procs/modules/documents/controller.php");


// Drawings
include_once(CO_INC . "/apps/procs/modules/drawings/config.php");
include_once(CO_INC . "/apps/procs/modules/drawings/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/drawings/model.php");
include_once(CO_INC . "/apps/procs/modules/drawings/controller.php");
$procsDrawings = new ProcsDrawings("drawings");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($procsDrawings->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($procsDrawings->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($procsDrawings->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($procsDrawings->createDuplicate($_GET['id']));
		break;
		case 'binDrawing':
			echo($procsDrawings->binDrawing($_GET['id']));
		break;
		case 'restoreDrawing':
			echo($procsDrawings->restoreDrawing($_GET['id']));
		break;
			case 'deleteDrawing':
			echo($procsDrawings->deleteDrawing($_GET['id']));
		break;
		case 'setOrder':
			echo($procs->setSortOrder("procs-drawings-sort",$_GET['drawingItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($procsDrawings->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($procsDrawings->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($procsDrawings->getSendtoDetails("procs_drawings",$_GET['id']));
		break;
		case 'checkinDrawing':
			echo($procsDrawings->checkinDrawing($_GET['id']));
		break;
		case 'toggleIntern':
			echo($procsDrawings->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'addTask':
			echo($procsDrawings->addTask($_GET['mid'],$_GET['num'],$_GET['sort']));
		break;
		case 'deleteTask':
			echo($procsDrawings->deleteTask($_GET['id']));
		break;
		case 'restoreDrawingTask':
			echo($procsDrawings->restoreDrawingTask($_GET['id']));
		break;
			case 'deleteDrawingTask':
			echo($procsDrawings->deleteDrawingTask($_GET['id']));
		break;
		case 'restoreDrawingDiagnose':
			echo($procsDrawings->restoreDrawingDiagnose($_GET['id']));
		break;
			case 'deleteDrawingDiagnose':
			echo($procsDrawings->deleteDrawingDiagnose($_GET['id']));
		break;
		case 'getDrawingStatusDialog':
			echo($procsDrawings->getDrawingStatusDialog());
		break;
		case 'getDrawingsTypeDialog':
			echo($procsDrawings->getDrawingsTypeDialog($_GET['field']));
		break;
		case 'getHelp':
			echo($procsDrawings->getHelp());
		break;
		case 'newCheckpoint':
			echo($procsDrawings->newCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'updateCheckpoint':
			echo($procsDrawings->updateCheckpoint($_GET['id'],$_GET['date']));
		break;
		case 'deleteCheckpoint':
			echo($procsDrawings->deleteCheckpoint($_GET['id']));
		break;
		case 'updateStatus':
			echo($procsDrawings->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
		//diagnose
		case 'updatePosition':
			echo($procsDrawings->updatePosition($_GET['id'],$_GET['x'],$_GET['y']));
		break;
		case 'addDiagnose':
			echo($procsDrawings->addDiagnose($_GET['mid'],$_GET['num']));
		break;
		case 'binDiagnose':
			echo($procsDrawings->binDiagnose($_GET['id']));
		break;
		case 'getDrawingTypeMin':
			echo($procsDrawings->getDrawingTypeMin($_GET['id']));
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($procsDrawings->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title'])));
		break;
		case 'sendDetails':
			echo($procsDrawings->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'updateCheckpointText':
			echo($procsDrawings->updateCheckpointText($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
		case 'saveDrawing':
			echo($procsDrawings->saveDrawing($_POST['id'],$_POST['img']));
		break;
	}
}

?>