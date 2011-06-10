<?php
$documents_name = "Aktenmappen";

$lang["DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["DOCUMENT_FILES"] = 'Dateien';

$lang["PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>