<?php
$productions_access_name = "Access";

$lang["PRODUCTION_ACCESSRIGHTS"] = 'Access Rights';

$lang["PRODUCTION_ACCESS_HELP"] = 'manual_projekte_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>