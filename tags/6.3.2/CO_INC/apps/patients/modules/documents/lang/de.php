<?php
$patients_documents_name = "Aktenmappen";

$lang["PATIENT_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["PATIENT_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["PATIENT_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["PATIENT_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["PATIENT_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["PATIENT_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["PATIENT_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["PATIENT_DOCUMENT_FILES"] = 'Dateien';

$lang["PATIENT_DOCUMENT_HELP"] = 'manual_mitarbeiter_aktenmappen.pdf';

$lang["PATIENT_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>