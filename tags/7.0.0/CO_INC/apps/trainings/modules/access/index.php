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

include_once(CO_INC . "/apps/trainings/modules/access/config.php");
include_once(CO_INC . "/apps/trainings/modules/access/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/trainings/modules/access/model.php");
include_once(CO_INC . "/apps/trainings/modules/access/controller.php");

$trainingsAccess = new TrainingsAccess("access");

// GET requests
if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($trainingsAccess->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($trainingsAccess->getDetails($_GET['id']));
		break;
		case 'getHelp':
			echo($trainingsAccess->getHelp());
		break;
	}
}

// GET requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($trainingsAccess->setDetails($_POST['pid'],$_POST['admins'],$_POST['guests']));
		break;
	}
}

?>