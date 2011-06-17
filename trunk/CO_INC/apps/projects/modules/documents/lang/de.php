<?php
$projects_documents_name = "Aktenmappen";

$lang["PROJECT_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["PROJECT_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["PROJECT_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["PROJECT_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["PROJECT_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["PROJECT_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["PROJECT_DOCUMENT_FILES"] = 'Dateien';

$lang["PROJECT_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>