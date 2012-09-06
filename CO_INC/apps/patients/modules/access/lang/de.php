<?php
$patients_access_name = "Zugang";

$lang["PATIENT_ACCESSRIGHTS"] = 'Berechtigungen';

$lang["PATIENT_ACCESS_HELP"] = 'manual_mitarbeiter_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>