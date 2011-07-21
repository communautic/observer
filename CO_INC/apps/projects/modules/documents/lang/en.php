<?php
$projects_documents_name = "Documents";

$lang["PROJECT_DOCUMENT_TITLE"] = 'Document';
$lang["PROJECT_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["PROJECT_DOCUMENT_NEW"] = 'New Document';
$lang["PROJECT_DOCUMENT_ACTION_NEW"] = 'new Document';
$lang["PROJECT_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["PROJECT_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["PROJECT_DOCUMENT_FILESIZE"] = 'Filesize';

$lang["PROJECT_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>