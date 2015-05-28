<?php
$evals_documents_name = "Files";

$lang["EVAL_DOCUMENT_TITLE"] = 'File';
$lang["EVAL_DOCUMENT_DOCUMENTS"] = 'Files';
$lang["EVAL_DOCUMENT_NEW"] = 'New File';
$lang["EVAL_DOCUMENT_ACTION_NEW"] = 'new File';
$lang["EVAL_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["EVAL_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["EVAL_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["EVAL_DOCUMENT_FILESIZE"] = 'Filesize';
$lang["EVAL_DOCUMENT_FILES"] = 'Files';

$lang["EVAL_DOCUMENT_HELP"] = 'manual_mitarbeiter_aktenmappen.pdf';

$lang["EVAL_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>