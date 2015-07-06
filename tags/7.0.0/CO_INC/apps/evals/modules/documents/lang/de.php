<?php
$evals_documents_name = "Aktenmappen";

$lang["EVAL_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["EVAL_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["EVAL_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["EVAL_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["EVAL_DOCUMENT_DESCRIPTION"] = 'Beschreibung';
$lang["EVAL_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["EVAL_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["EVAL_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["EVAL_DOCUMENT_FILES"] = 'Dateien';

$lang["EVAL_DOCUMENT_HELP"] = 'manual_mitarbeiter_aktenmappen.pdf';

$lang["EVAL_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>