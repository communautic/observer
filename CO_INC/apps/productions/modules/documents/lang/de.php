<?php
$productions_documents_name = "Aktenmappen";

$lang["PRODUCTION_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["PRODUCTION_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["PRODUCTION_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["PRODUCTION_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["PRODUCTION_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["PRODUCTION_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["PRODUCTION_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["PRODUCTION_DOCUMENT_FILES"] = 'Dateien';

$lang["PRODUCTION_DOCUMENT_HELP"] = 'manual_projekte_aktenmappen.pdf';

$lang["PRODUCTION_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>