<?php
$forums_documents_name = "Documents";

$lang["FORUM_DOCUMENT_TITLE"] = 'Document';
$lang["FORUM_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["FORUM_DOCUMENT_NEW"] = 'New Document';
$lang["FORUM_DOCUMENT_ACTION_NEW"] = 'new Document';
$lang["FORUM_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["FORUM_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["FORUM_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["FORUM_DOCUMENT_FILESIZE"] = 'Filesize';
$lang["FORUM_DOCUMENT_FILES"] = 'Files';

$lang["FORUM_DOCUMENT_HELP"] = 'manual_foren_aktenmappen.pdf';

$lang["FORUM_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>