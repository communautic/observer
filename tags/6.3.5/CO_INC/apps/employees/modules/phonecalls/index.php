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
include_once(CO_INC . "/apps/employees/modules/documents/config.php");
include_once(CO_INC . "/apps/employees/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/documents/model.php");
include_once(CO_INC . "/apps/employees/modules/documents/controller.php");


// Phonecalls
include_once(CO_INC . "/apps/employees/modules/phonecalls/config.php");
include_once(CO_INC . "/apps/employees/modules/phonecalls/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/employees/modules/phonecalls/model.php");
include_once(CO_INC . "/apps/employees/modules/phonecalls/controller.php");
$employeesPhonecalls = new EmployeesPhonecalls("phonecalls");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($employeesPhonecalls->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($employeesPhonecalls->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($employeesPhonecalls->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($employeesPhonecalls->createDuplicate($_GET['id']));
		break;
		case 'binPhonecall':
			echo($employeesPhonecalls->binPhonecall($_GET['id']));
		break;
		case 'restorePhonecall':
			echo($employeesPhonecalls->restorePhonecall($_GET['id']));
		break;
			case 'deletePhonecall':
			echo($employeesPhonecalls->deletePhonecall($_GET['id']));
		break;
		case 'setOrder':
			echo($employees->setSortOrder("employees-phonecalls-sort",$_GET['phonecallItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($employeesPhonecalls->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($employeesPhonecalls->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($employeesPhonecalls->getSendtoDetails("employees_phonecalls",$_GET['id']));
		break;
		case 'checkinPhonecall':
			echo($employeesPhonecalls->checkinPhonecall($_GET['id']));
		break;
		case 'toggleIntern':
			echo($employeesPhonecalls->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getPhonecallStatusDialog':
			echo($employeesPhonecalls->getPhonecallStatusDialog());
		break;
		case 'getHelp':
			echo($employeesPhonecalls->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($employeesPhonecalls->setDetails($_POST['pid'], $_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['item_date'], $_POST['phonecallstart'], $_POST['phonecallend'], $system->checkMagicQuotes($_POST['protocol']), $_POST['management'], $system->checkMagicQuotes($_POST['management_ct']),$_POST['documents'],$_POST['phonecall_access'],$_POST['phonecall_access_orig'],$_POST['phonecall_status'],$_POST['phonecall_status_date']));
		break;
		case 'sendDetails':
			echo($employeesPhonecalls->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>