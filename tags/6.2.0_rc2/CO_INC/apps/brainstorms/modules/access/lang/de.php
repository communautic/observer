<?php
$brainstorms_access_name = "Zugang";

$lang["BRAINSTORM_ACCESSRIGHTS"] = 'Berechtigungen';

$lang["BRAINSTORM_ACCESS_HELP"] = 'manual_prozesse_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>