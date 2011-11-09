<?php
$clients_access_name = "Zugang";

$lang["CLIENT_ACCESSRIGHTS"] = 'Berechtigungen';

$lang["CLIENT_ACCESS_HELP"] = 'manual_projekte_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>