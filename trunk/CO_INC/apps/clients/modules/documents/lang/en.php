<?php
$clients_documents_name = "Documents";

$lang["CLIENT_DOCUMENT_TITLE"] = 'Document';
$lang["CLIENT_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["CLIENT_DOCUMENT_NEW"] = 'New Document';
$lang["CLIENT_DOCUMENT_ACTION_NEW"] = 'new Document';
$lang["CLIENT_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["CLIENT_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["CLIENT_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["CLIENT_DOCUMENT_FILESIZE"] = 'Filesize';

$lang["CLIENT_DOCUMENT_HELP"] = 'manual_kunden_aktenmappen.pdf';

$lang["CLIENT_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>