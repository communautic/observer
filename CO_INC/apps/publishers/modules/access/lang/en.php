<?php
$publishers_access_name = "Access";

$lang["PUBLISHER_ACCESSRIGHTS"] = 'Access Rights';

$lang["PUBLISHER_ACCESS_HELP"] = 'manual_projekte_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/publishers/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>