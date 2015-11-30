<?php
$patients_vdocs_name = "Documents";

$lang["PATIENT_VDOC_TITLE"] = 'Document';
$lang["PATIENT_VDOC_VDOCS"] = 'Documents';
$lang["PATIENT_VDOC_NEW"] = 'New Document';
$lang["PATIENT_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["PATIENT_VDOC_HELP"] = 'manual_projekte_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>