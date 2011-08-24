<?php
$brainstorms_documents_name = "Documents";

$lang["BRAINSTORM_DOCUMENT_TITLE"] = 'Document';
$lang["BRAINSTORM_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["BRAINSTORM_DOCUMENT_NEW"] = 'New Document';
$lang["BRAINSTORM_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["BRAINSTORM_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["BRAINSTORM_DOCUMENT_FILESIZE"] = 'Filesize';

$lang["BRAINSTORM_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>