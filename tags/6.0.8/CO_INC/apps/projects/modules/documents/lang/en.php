<?php
$documents_name = "Documents";

$lang["DOCUMENT_TITLE"] = 'Document';
$lang["DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["DOCUMENT_NEW"] = 'New Document';
$lang["DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["DOCUMENT_FILESIZE"] = 'Filesize';

$lang["PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>