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

foreach($publishers->modules as $module  => $value) {
	include_once("modules/".$module."/config.php");
	include_once("modules/".$module."/lang/" . $session->userlang . ".php");
	include_once("modules/".$module."/model.php");
	include_once("modules/".$module."/controller.php");
}

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getContactsDialog':
			echo($contacts->getContactsDialog($_GET['request'],$_GET['field'],$_GET['append'],$_GET['title'],$_GET['sql']));
		break;
		case 'getAccessDialog':
			echo($publishers->getAccessDialog());
		break;
		case 'getBin':
			echo($publishers->getBin());
		break;
		case 'emptyBin':
			echo($publishers->emptyBin());
		break;

	}
}
?>