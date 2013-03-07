<?php
$trainings_documents_name = "Documents";

$lang["TRAINING_DOCUMENT_TITLE"] = 'Document';
$lang["TRAINING_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["TRAINING_DOCUMENT_NEW"] = 'New Document';
$lang["TRAINING_DOCUMENT_ACTION_NEW"] = 'new Document';
$lang["TRAINING_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["TRAINING_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["TRAINING_DOCUMENT_FILESIZE"] = 'Filesize';

$lang["TRAINING_DOCUMENT_HELP"] = 'manual_trainings_aktenmappen.pdf';

$lang["TRAINING_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>