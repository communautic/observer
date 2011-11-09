<?php
$clients_orders_name = "Bestellungen";

$lang["CLIENT_ORDER_TITLE"] = 'Bestellung';
$lang["CLIENT_ORDERS"] = 'Bestellungen';

$lang["CLIENT_ORDER_NEW"] = 'Neue Bestellung';
$lang["CLIENT_ORDER_ACTION_NEW"] = 'neue Bestellung anlegen';

$lang["CLIENT_ORDER_DATE"] = 'Bestelldatum';
$lang["CLIENT_ORDER_TIME_START"] = 'Start';
$lang["CLIENT_ORDER_TIME_END"] = 'Ende';

$lang["CLIENT_ORDER_MANAGEMENT"] = 'Auftraggeber';
$lang["CLIENT_ORDER_GOALS"] = 'Notizen';

$lang["CLIENT_ORDER_STATUS_OPEN"] = 'offen';
$lang["CLIENT_ORDER_STATUS_DONE"] = 'gestellt';


$lang["CLIENT_ORDER_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["CLIENT_PRINT_ORDER"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/orders/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>