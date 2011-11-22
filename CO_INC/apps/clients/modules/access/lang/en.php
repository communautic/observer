<?php
$clients_access_name = "Access";

$lang["CLIENT_ACCESSRIGHTS"] = 'Access Rights';

$lang["CLIENT_ACCESS_HELP"] = 'manual_kunden_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>