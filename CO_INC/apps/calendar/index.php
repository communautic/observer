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

/*foreach($calendar->modules as $module  => $value) {
	include_once("modules/".$module."/config.php");
	include_once("modules/".$module."/lang/" . $session->userlang . ".php");
	include_once("modules/".$module."/model.php");
	include_once("modules/".$module."/controller.php");
}*/

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getrequestedEvents':
			echo($calendar->getrequestedEvents($_GET["calendar_id"], $_GET["start"], $_GET["end"]));
			//echo '[{"id":111,"title":"Event1","start":"2013-12-10","url":"http:\/\/yahoo.com\/"},{"id":222,"title":"Event2","start":"2013-12-20","end":"2013-12-22","url":"http:\/\/yahoo.com\/"}]';
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'setFolderDetails':
			echo($projects->setFolderDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $_POST['projectstatus']));
		break;
	}
}
?>