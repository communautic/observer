<?php
$productions_documents_name = "Documents";

$lang["PRODUCTION_DOCUMENT_TITLE"] = 'Document';
$lang["PRODUCTION_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["PRODUCTION_DOCUMENT_NEW"] = 'New Document';
$lang["PRODUCTION_DOCUMENT_ACTION_NEW"] = 'new Document';
$lang["PRODUCTION_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["PRODUCTION_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["PRODUCTION_DOCUMENT_FILESIZE"] = 'Filesize';

$lang["PRODUCTION_DOCUMENT_HELP"] = 'manual_projekte_aktenmappen.pdf';

$lang["PRODUCTION_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>