<?php
$trainings_access_name = "Zugang";

$lang["TRAINING_ACCESSRIGHTS"] = 'Berechtigungen';

$lang["TRAINING_ACCESS_HELP"] = 'manual_reklamationen_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>