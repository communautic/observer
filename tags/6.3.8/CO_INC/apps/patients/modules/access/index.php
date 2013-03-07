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

include_once(CO_INC . "/apps/patients/modules/access/config.php");
include_once(CO_INC . "/apps/patients/modules/access/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/patients/modules/access/model.php");
include_once(CO_INC . "/apps/patients/modules/access/controller.php");

$patientsAccess = new PatientsAccess("access");

// GET requests
if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($patientsAccess->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($patientsAccess->getDetails($_GET['id']));
		break;
		case 'getHelp':
			echo($patientsAccess->getHelp());
		break;
	}
}

// GET requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($patientsAccess->setDetails($_POST['pid'],$_POST['admins'],$_POST['guests']));
		break;
	}
}

?>