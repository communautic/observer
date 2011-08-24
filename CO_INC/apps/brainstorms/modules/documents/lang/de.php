<?php
$brainstorms_documents_name = "Aktenmappen";

$lang["BRAINSTORM_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["BRAINSTORM_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["BRAINSTORM_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["BRAINSTORM_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["BRAINSTORM_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["BRAINSTORM_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["BRAINSTORM_DOCUMENT_FILES"] = 'Dateien';

$lang["BRAINSTORM_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>