<?php
$access_name = "Zugang";

$lang["ACCESSRIGHTS"] = 'Berechtigungen';

$lang["ACCESS_ADMINS"] = 'Administratoren';
$lang["ACCESS_GUESTS"] = 'Beobachter';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>