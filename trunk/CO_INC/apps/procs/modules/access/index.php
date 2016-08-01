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

include_once(CO_INC . "/apps/procs/modules/access/config.php");
include_once(CO_INC . "/apps/procs/modules/access/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/procs/modules/access/model.php");
include_once(CO_INC . "/apps/procs/modules/access/controller.php");

$procsAccess = new ProcsAccess("access");

// GET requests
if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($procsAccess->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($procsAccess->getDetails($_GET['id'],$_GET['fid']));
		break;
		case 'getHelp':
			echo($procsAccess->getHelp());
		break;
		case 'getListArchive':
			$sort = "0";
			echo($procsAccess->getListArchive($_GET['id'],$sort));
		break;
		case 'getDetailsArchive':
			echo($procsAccess->getDetailsArchive($_GET['id']));
		break;
	}
}

// GET requests
if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($procsAccess->setDetails($_POST['pid'],$_POST['admins'],$_POST['guests']));
		break;
	}
}

?>