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

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'updateColum':
			$item = array();
			if(isset($_GET["item"])) {
				$item = $_GET["item"];
			}
			echo($desktop->updateColum($_GET["col"],$_GET["item"]));
		break;
		case 'setWidgetStatus':
			echo($desktop->setWidgetStatus($_GET["object"],$_GET["status"]));
		break;
		case 'getPostIts':
			echo($desktop->getPostIts());
		break;
		case 'newPostit':
			echo($desktop->newPostit($_GET['z']));
		break;
		case 'updatePostitPosition':
			echo($desktop->updatePostitPosition($_GET['id'],$_GET['x'],$_GET['y'],$_GET['z']));
		break;
		case 'updatePostitSize':
			echo($desktop->updatePostitSize($_GET['id'],$_GET['w'],$_GET['h']));
		break;
		case 'deletePostit':
			echo($desktop->deletePostit($_GET['id']));
		break;
		case 'getDesktopHelp':
			echo($desktop->getDesktopHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'savePostit':
			echo($desktop->savePostit($_POST['id'],$system->checkMagicQuotes($_POST['text'])));
		break;
	}
	switch ($_POST['request']) {
		case 'forwardPostit':
			echo($desktop->forwardPostit($_POST['id'],$_POST['users']));
		break;
	}
}
?>