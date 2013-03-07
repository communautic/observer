<?php
$complaints_documents_name = "Aktenmappen";

$lang["COMPLAINT_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["COMPLAINT_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["COMPLAINT_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["COMPLAINT_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["COMPLAINT_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["COMPLAINT_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["COMPLAINT_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["COMPLAINT_DOCUMENT_FILES"] = 'Dateien';

$lang["COMPLAINT_DOCUMENT_HELP"] = 'manual_reklamationen_aktenmappen.pdf';

$lang["COMPLAINT_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>