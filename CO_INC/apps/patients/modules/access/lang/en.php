<?php
$patients_access_name = "Access";

$lang["PATIENT_ACCESSRIGHTS"] = 'Access Rights';

$lang["PATIENT_ACCESS_HELP"] = 'manual_patienten_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>