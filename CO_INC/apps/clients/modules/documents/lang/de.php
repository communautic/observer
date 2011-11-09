<?php
$clients_documents_name = "Aktenmappen";

$lang["CLIENT_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["CLIENT_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["CLIENT_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["CLIENT_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["CLIENT_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["CLIENT_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["CLIENT_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["CLIENT_DOCUMENT_FILES"] = 'Dateien';

$lang["CLIENT_DOCUMENT_HELP"] = 'manual_projekte_aktenmappen.pdf';

$lang["CLIENT_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>