<?php
$trainings_documents_name = "Files";

$lang["TRAINING_DOCUMENT_TITLE"] = 'File';
$lang["TRAINING_DOCUMENT_DOCUMENTS"] = 'Files';
$lang["TRAINING_DOCUMENT_NEW"] = 'New File';
$lang["TRAINING_DOCUMENT_ACTION_NEW"] = 'new File';
$lang["TRAINING_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["TRAINING_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["TRAINING_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["TRAINING_DOCUMENT_FILESIZE"] = 'Filesize';
$lang["TRAINING_DOCUMENT_FILES"] = 'Files';

$lang["TRAINING_DOCUMENT_HELP"] = 'manual_trainings_aktenmappen.pdf';

$lang["TRAINING_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>