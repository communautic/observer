<?php
$clients_documents_name = "Files";

$lang["CLIENT_DOCUMENT_TITLE"] = 'File';
$lang["CLIENT_DOCUMENT_DOCUMENTS"] = 'Files';
$lang["CLIENT_DOCUMENT_NEW"] = 'New File';
$lang["CLIENT_DOCUMENT_ACTION_NEW"] = 'new File';
$lang["CLIENT_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["CLIENT_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["CLIENT_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["CLIENT_DOCUMENT_FILESIZE"] = 'Filesize';
$lang["CLIENT_DOCUMENT_FILES"] = 'Files';

$lang["CLIENT_DOCUMENT_HELP"] = 'manual_kunden_aktenmappen.pdf';

$lang["CLIENT_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>