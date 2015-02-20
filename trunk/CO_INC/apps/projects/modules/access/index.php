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

include_once(CO_INC . "/apps/projects/modules/access/config.php");
include_once(CO_INC . "/apps/projects/modules/access/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/projects/modules/access/model.php");
include_once(CO_INC . "/apps/projects/modules/access/controller.php");

$projectsAccess = new ProjectsAccess("access");

// GET requests
if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($projectsAccess->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($projectsAccess->getDetails($_GET['id']));
		break;
		case 'getHelp':
			echo($projectsAccess->getHelp());
		break;
		case 'getListArchive':
			$sort = "0";
			echo($projectsAccess->getListArchive($_GET['id'],$sort));
		break;
		case 'getDetailsArchive':
			echo($projectsAccess->getDetailsArchive($_GET['id']));
		break;
	}
}

// GET requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($projectsAccess->setDetails($_POST['pid'],$_POST['admins'],$_POST['guests']));
		break;
	}
}

?>