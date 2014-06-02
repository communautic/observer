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
include_once(CO_INC . "/apps/patients/modules/documents/config.php");
include_once(CO_INC . "/apps/patients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/documents/model.php");
include_once(CO_INC . "/apps/patients/modules/documents/controller.php");


// Phonecalls
include_once(CO_INC . "/apps/patients/modules/phonecalls/config.php");
include_once(CO_INC . "/apps/patients/modules/phonecalls/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/phonecalls/model.php");
include_once(CO_INC . "/apps/patients/modules/phonecalls/controller.php");
$patientsPhonecalls = new PatientsPhonecalls("phonecalls");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsPhonecalls->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsPhonecalls->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($patientsPhonecalls->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($patientsPhonecalls->createDuplicate($_GET['id']));
		break;
		case 'binPhonecall':
			echo($patientsPhonecalls->binPhonecall($_GET['id']));
		break;
		case 'restorePhonecall':
			echo($patientsPhonecalls->restorePhonecall($_GET['id']));
		break;
			case 'deletePhonecall':
			echo($patientsPhonecalls->deletePhonecall($_GET['id']));
		break;
		case 'setOrder':
			echo($patients->setSortOrder("patients-phonecalls-sort",$_GET['phonecallItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($patientsPhonecalls->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($patientsPhonecalls->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($patientsPhonecalls->getSendtoDetails("patients_phonecalls",$_GET['id']));
		break;
		case 'checkinPhonecall':
			echo($patientsPhonecalls->checkinPhonecall($_GET['id']));
		break;
		case 'toggleIntern':
			echo($patientsPhonecalls->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getPhonecallStatusDialog':
			echo($patientsPhonecalls->getPhonecallStatusDialog());
		break;
		case 'getHelp':
			echo($patientsPhonecalls->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($patientsPhonecalls->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['phonecallstart'], $_POST['phonecallend'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['phonecall_access'],$_POST['phonecall_access_orig'],$_POST['phonecall_status'],$_POST['phonecall_status_date']));
		break;
		case 'sendDetails':
			echo($patientsPhonecalls->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>