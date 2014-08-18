<?php
$patients_vdocs_name = "Textbeiträge";

$lang["PATIENT_VDOC_TITLE"] = 'Textbeitrag';
$lang["PATIENT_VDOC_VDOCS"] = 'Textbeiträge';
$lang["PATIENT_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["PATIENT_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["PATIENT_VDOC_HELP"] = 'manual_projekte_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>