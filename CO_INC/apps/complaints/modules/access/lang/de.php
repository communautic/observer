<?php
$complaints_access_name = "Zugang";

$lang["COMPLAINT_ACCESSRIGHTS"] = 'Berechtigungen';

$lang["COMPLAINT_ACCESS_HELP"] = 'manual_reklamationen_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>