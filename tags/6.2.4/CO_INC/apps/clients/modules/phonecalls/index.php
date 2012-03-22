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
include_once(CO_INC . "/apps/clients/modules/documents/config.php");
include_once(CO_INC . "/apps/clients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/clients/modules/documents/model.php");
include_once(CO_INC . "/apps/clients/modules/documents/controller.php");


// Phonecalls
include_once(CO_INC . "/apps/clients/modules/phonecalls/config.php");
include_once(CO_INC . "/apps/clients/modules/phonecalls/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/clients/modules/phonecalls/model.php");
include_once(CO_INC . "/apps/clients/modules/phonecalls/controller.php");
$clientsPhonecalls = new ClientsPhonecalls("phonecalls");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($clientsPhonecalls->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($clientsPhonecalls->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($clientsPhonecalls->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($clientsPhonecalls->createDuplicate($_GET['id']));
		break;
		case 'binPhonecall':
			echo($clientsPhonecalls->binPhonecall($_GET['id']));
		break;
		case 'restorePhonecall':
			echo($clientsPhonecalls->restorePhonecall($_GET['id']));
		break;
			case 'deletePhonecall':
			echo($clientsPhonecalls->deletePhonecall($_GET['id']));
		break;
		case 'setOrder':
			echo($clients->setSortOrder("clients-phonecalls-sort",$_GET['phonecallItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($clientsPhonecalls->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($clientsPhonecalls->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($clientsPhonecalls->getSendtoDetails("clients_phonecalls",$_GET['id']));
		break;
		case 'checkinPhonecall':
			echo($clientsPhonecalls->checkinPhonecall($_GET['id']));
		break;
		case 'toggleIntern':
			echo($clientsPhonecalls->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getPhonecallStatusDialog':
			echo($clientsPhonecalls->getPhonecallStatusDialog());
		break;
		case 'getHelp':
			echo($clientsPhonecalls->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($clientsPhonecalls->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['phonecallstart'], $_POST['phonecallend'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['phonecall_access'],$_POST['phonecall_access_orig'],$_POST['phonecall_status'],$_POST['phonecall_status_date']));
		break;
		case 'sendDetails':
			echo($clientsPhonecalls->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>