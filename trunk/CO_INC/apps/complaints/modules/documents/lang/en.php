<?php
$complaints_documents_name = "Files";

$lang["COMPLAINT_DOCUMENT_TITLE"] = 'File';
$lang["COMPLAINT_DOCUMENT_DOCUMENTS"] = 'Files';
$lang["COMPLAINT_DOCUMENT_NEW"] = 'New File';
$lang["COMPLAINT_DOCUMENT_ACTION_NEW"] = 'new File';
$lang["COMPLAINT_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["COMPLAINT_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["COMPLAINT_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["COMPLAINT_DOCUMENT_FILESIZE"] = 'Filesize';
$lang["COMPLAINT_DOCUMENT_FILES"] = 'Files';

$lang["COMPLAINT_DOCUMENT_HELP"] = 'manual_reklamationen_aktenmappen.pdf';

$lang["COMPLAINT_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>