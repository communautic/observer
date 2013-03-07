<?php
$trainings_documents_name = "Aktenmappen";

$lang["TRAINING_DOCUMENT_TITLE"] = 'Aktenmappe';
$lang["TRAINING_DOCUMENT_DOCUMENTS"] = 'Aktenmappe';
$lang["TRAINING_DOCUMENT_NEW"] = 'Neue Aktenmappe';
$lang["TRAINING_DOCUMENT_ACTION_NEW"] = 'neue Aktenmappe anlegen';
$lang["TRAINING_DOCUMENT_UPLOAD"] = 'Datei / Upload';
$lang["TRAINING_DOCUMENT_FILENAME"] = 'Dateiname/Format';
$lang["TRAINING_DOCUMENT_FILESIZE"] = 'Dateigrösse';
$lang["TRAINING_DOCUMENT_FILES"] = 'Dateien';

$lang["TRAINING_DOCUMENT_HELP"] = 'manual_trainings_aktenmappen.pdf';

$lang["TRAINING_PRINT_DOCUMENT"] = 'akt.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/documents/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>