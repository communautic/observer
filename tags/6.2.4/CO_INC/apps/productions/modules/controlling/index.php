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

// needs phases config file for db
include_once(CO_INC . "/apps/productions/modules/phases/config.php");
include_once(CO_INC . "/apps/productions/modules/phases/lang/" . $session->userlang . ".php");

include_once(CO_INC . "/apps/productions/modules/meetings/config.php");
include_once(CO_INC . "/apps/productions/modules/meetings/lang/" . $session->userlang . ".php");

include_once(CO_INC . "/apps/productions/modules/controlling/config.php");
include_once(CO_INC . "/apps/productions/modules/controlling/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/productions/modules/controlling/model.php");
include_once(CO_INC . "/apps/productions/modules/controlling/controller.php");

$productionsControlling = new ProductionsControlling("controlling");

if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($productionsControlling->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($productionsControlling->getDetails($_GET['id'],$_GET['pid']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($productionsControlling->printDetails($_GET['id'],$_GET['pid'],$t));
		break;
		case 'getSend':
			echo($productionsControlling->getSend($_GET['id'],$_GET['pid']));
		break;
		case 'getSendtoDetails':
			echo($productionsControlling->getSendtoDetails("productions_controlling",$_GET['id']));
		break;
		case 'getDailyStatistic':
			$md5 = "8434a915e0326f424aa8228c9261524e";
			$k = $_GET['k'];
			if($md5 != $k) {
				exit();
			}
			echo($productionsControlling->getDailyStatistic());
		break;
		case 'getHelp':
			echo($productionsControlling->getHelp());
		break;
	}
}

if (!empty($_POST['request'])) {
	switch ($_POST['request']) {
		case 'sendDetails':
			echo($productionsControlling->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>