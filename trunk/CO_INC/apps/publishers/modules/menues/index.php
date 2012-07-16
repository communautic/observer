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
/*include_once(CO_INC . "/apps/publishers/modules/documents/config.php");
include_once(CO_INC . "/apps/publishers/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/publishers/modules/documents/model.php");
include_once(CO_INC . "/apps/publishers/modules/documents/controller.php");*/


// Menues
include_once(CO_INC . "/apps/publishers/modules/menues/config.php");
include_once(CO_INC . "/apps/publishers/modules/menues/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/publishers/modules/menues/model.php");
include_once(CO_INC . "/apps/publishers/modules/menues/controller.php");
$publishersMenues = new PublishersMenues("menues");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($publishersMenues->getList($sort));
		break;
		case 'getDetails':
			echo($publishersMenues->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($publishersMenues->createNew());
		break;
		case 'createDuplicate':
			echo($publishersMenues->createDuplicate($_GET['id']));
		break;
		case 'binMenue':
			echo($publishersMenues->binMenue($_GET['id']));
		break;
		case 'restoreMenue':
			echo($publishersMenues->restoreMenue($_GET['id']));
		break;
			case 'deleteMenue':
			echo($publishersMenues->deleteMenue($_GET['id']));
		break;
		case 'setOrder':
			echo($publishers->setSortOrder("publishers-menues-sort",$_GET['menueItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($publishersMenues->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($publishersMenues->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($publishersMenues->getSendtoDetails("publishers_menues",$_GET['id']));
		break;
		case 'checkinMenue':
			echo($publishersMenues->checkinMenue($_GET['id']));
		break;
		case 'toggleIntern':
			echo($publishersMenues->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getMenueStatusDialog':
			echo($publishersMenues->getMenueStatusDialog());
		break;
		case 'getHelp':
			echo($publishersMenues->getHelp());
		break;
		case 'archiveOthers':
			echo($publishersMenues->archiveOthers($_GET['id']));
		break;
		case 'getMenuesDialog':
			echo($publishersMenues->getMenuesDialog($_GET['field']));
		break;
		case 'updateStatus':
			echo($publishersMenues->updateStatus($_GET['id'],$_GET['date'],$_GET['status']));
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($publishersMenues->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date_from'], $_POST['item_date_to'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['menue_access'],$_POST['menue_access_orig']));
		break;
		case 'sendDetails':
			echo($publishersMenues->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
		case 'saveItem':
			echo($publishersMenues->saveItem($_POST["id"],$_POST["what"],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
}

?>