<?php
$procs_access_name = "Zugang";

$lang["PROC_ACCESSRIGHTS"] = 'Berechtigungen';

$lang["PROC_ACCESS_HELP"] = 'manual_prozesse_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>