<?php
$trainings_access_name = "Access";

$lang["TRAINING_ACCESSRIGHTS"] = 'Access Rights';

$lang["TRAINING_ACCESS_HELP"] = 'manual_reklamationen_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>