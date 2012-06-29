<?php
$forums_documents_name = "Aktenmappen";

$lang["FORUM_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["FORUM_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["FORUM_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["FORUM_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["FORUM_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["FORUM_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["FORUM_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["FORUM_DOCUMENT_FILES"] = 'Dateien';

$lang["FORUM_DOCUMENT_HELP"] = 'manual_foren_aktenmappen.pdf';

$lang["FORUM_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>