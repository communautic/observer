<?php
$procs_documents_name = "Aktenmappen";

$lang["PROC_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["PROC_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["PROC_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["PROC_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["PROC_DOCUMENT_DESCRIPTION"] = 'Beschreibung';
$lang["PROC_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["PROC_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["PROC_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["PROC_DOCUMENT_FILES"] = 'Dateien';

$lang["PROC_DOCUMENT_HELP"] = 'manual_prozesse_aktenmappen.pdf';

$lang["PROC_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>