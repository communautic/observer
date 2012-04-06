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
include_once(CO_INC . "/apps/productions/modules/documents/config.php");
include_once(CO_INC . "/apps/productions/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/productions/modules/documents/model.php");
include_once(CO_INC . "/apps/productions/modules/documents/controller.php");


// Phonecalls
include_once(CO_INC . "/apps/productions/modules/phonecalls/config.php");
include_once(CO_INC . "/apps/productions/modules/phonecalls/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/productions/modules/phonecalls/model.php");
include_once(CO_INC . "/apps/productions/modules/phonecalls/controller.php");
$productionsPhonecalls = new ProductionsPhonecalls("phonecalls");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($productionsPhonecalls->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($productionsPhonecalls->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($productionsPhonecalls->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($productionsPhonecalls->createDuplicate($_GET['id']));
		break;
		case 'binPhonecall':
			echo($productionsPhonecalls->binPhonecall($_GET['id']));
		break;
		case 'restorePhonecall':
			echo($productionsPhonecalls->restorePhonecall($_GET['id']));
		break;
			case 'deletePhonecall':
			echo($productionsPhonecalls->deletePhonecall($_GET['id']));
		break;
		case 'setOrder':
			echo($productions->setSortOrder("productions-phonecalls-sort",$_GET['phonecallItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productionsPhonecalls->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($productionsPhonecalls->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($productionsPhonecalls->getSendtoDetails("productions_phonecalls",$_GET['id']));
		break;
		case 'checkinPhonecall':
			echo($productionsPhonecalls->checkinPhonecall($_GET['id']));
		break;
		case 'toggleIntern':
			echo($productionsPhonecalls->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getPhonecallStatusDialog':
			echo($productionsPhonecalls->getPhonecallStatusDialog());
		break;
		case 'getHelp':
			echo($productionsPhonecalls->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($productionsPhonecalls->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['phonecallstart'], $_POST['phonecallend'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['phonecall_access'],$_POST['phonecall_access_orig'],$_POST['phonecall_status'],$_POST['phonecall_status_date']));
		break;
		case 'sendDetails':
			echo($productionsPhonecalls->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>