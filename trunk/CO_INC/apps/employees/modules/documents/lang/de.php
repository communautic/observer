<?php
$employees_documents_name = "Aktenmappen";

$lang["EMPLOYEE_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["EMPLOYEE_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["EMPLOYEE_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["EMPLOYEE_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["EMPLOYEE_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["EMPLOYEE_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["EMPLOYEE_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["EMPLOYEE_DOCUMENT_FILES"] = 'Dateien';

$lang["EMPLOYEE_DOCUMENT_HELP"] = 'manual_mitarbeiter_aktenmappen.pdf';

$lang["EMPLOYEE_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>