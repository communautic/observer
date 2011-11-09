<?php
$clients_orders_name = "Orders";

$lang["CLIENT_ORDER_TITLE"] = 'Order';
$lang["CLIENT_ORDERS"] = 'Orders';

$lang["CLIENT_ORDER_NEW"] = 'New Order';
$lang["CLIENT_ORDER_ACTION_NEW"] = 'new Order';

$lang["CLIENT_ORDER_DATE"] = 'Date';
$lang["CLIENT_ORDER_TIME_START"] = 'Start';
$lang["CLIENT_ORDER_TIME_END"] = 'End';

$lang["CLIENT_ORDER_MANAGEMENT"] = 'With';
$lang["CLIENT_ORDER_GOALS"] = 'Agenda';

$lang["CLIENT_ORDER_STATUS_OUTGOING"] = 'incoming';
$lang["CLIENT_ORDER_STATUS_ON_INCOMING"] = 'outgoing';

$lang["CLIENT_ORDER_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["CLIENT_PRINT_ORDER"] = 'order.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/orders/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>