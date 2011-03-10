<?php
$documents_name = "Akten";

$lang["DOCUMENT_TITLE"] = 'Akt';
$lang["DOCUMENT_DOCUMENTS"] = 'Akten';
$lang["DOCUMENT_NEW"] = 'Neuer Akt';
$lang["DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["DOCUMENT_FILESIZE"] = 'Dateigrösse';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>