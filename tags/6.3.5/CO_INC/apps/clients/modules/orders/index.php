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
include_once(CO_INC . "/apps/clients/modules/documents/config.php");
include_once(CO_INC . "/apps/clients/modules/documents/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/clients/modules/documents/model.php");
include_once(CO_INC . "/apps/clients/modules/documents/controller.php");


// Orders
include_once(CO_INC . "/apps/clients/modules/orders/config.php");
include_once(CO_INC . "/apps/clients/modules/orders/lang/" . $session->userlang . ".php");
include_once(CO_INC . "/apps/clients/modules/orders/model.php");
include_once(CO_INC . "/apps/clients/modules/orders/controller.php");
$clientsOrders = new ClientsOrders("orders");


if (!empty($_GET['request'])) {
	switch ($_GET['request']) {
		case 'getList':
			$sort = "0";
			if(!empty($_GET['sort'])) {
				$sort = $_GET['sort'];
			}
			echo($clientsOrders->getList($_GET['id'],$sort));
		break;
		case 'getDetails':
			echo($clientsOrders->getDetails($_GET['id']));
		break;
		case 'createNew':
			echo($clientsOrders->createNew($_GET['id']));
		break;
		case 'createDuplicate':
			echo($clientsOrders->createDuplicate($_GET['id']));
		break;
		case 'binOrder':
			echo($clientsOrders->binOrder($_GET['id']));
		break;
		case 'restoreOrder':
			echo($clientsOrders->restoreOrder($_GET['id']));
		break;
			case 'deleteOrder':
			echo($clientsOrders->deleteOrder($_GET['id']));
		break;
		case 'setOrder':
			echo($clients->setSortOrder("clients-orders-sort",$_GET['orderItem'],$_GET['id']));
		break;
		case 'printDetails':
			$t = "pdf"; // options: pdf, html
			if(!empty($_GET['t'])) {
				$t = $_GET['t'];
			}
			echo($clientsOrders->printDetails($_GET['id'],$t));
		break;
		case 'getSend':
			echo($clientsOrders->getSend($_GET['id']));
		break;
		case 'getSendtoDetails':
			echo($clientsOrders->getSendtoDetails("clients_orders",$_GET['id']));
		break;
		case 'checkinOrder':
			echo($clientsOrders->checkinOrder($_GET['id']));
		break;
		case 'toggleIntern':
			echo($clientsOrders->toggleIntern($_GET['id'],$_GET['status']));
		break;
		case 'getOrderStatusDialog':
			echo($clientsOrders->getOrderStatusDialog());
		break;
		case 'getHelp':
			echo($clientsOrders->getHelp());
		break;
		case 'createExcel':
			echo($clientsOrders->createExcel($_GET['folderid'],$_GET['menueid']));
		break;
	}
}

if (!empty($_POST['request'])) {
	
	switch ($_POST['request']) {
		case 'setDetails':
			echo($clientsOrders->setDetails($_POST['id'], $system->checkMagicQuotes($_POST['title']), $system->checkMagicQuotes($_POST['protocol']),$_POST['documents'],$_POST['order_access'],$_POST['order_access_orig'],$_POST['order_status'],$_POST['order_status_date']));
		break;
		case 'sendDetails':
			echo($clientsOrders->sendDetails($_POST['id'], $_POST['variable'], $_POST['to'], $_POST['cc'], $system->checkMagicQuotesTinyMCE($_POST['subject']), $system->checkMagicQuotesTinyMCE($_POST['body'])));
		break;
	}
}

?>