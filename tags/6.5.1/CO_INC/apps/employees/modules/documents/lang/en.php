<?php
$employees_documents_name = "Documents";

$lang["EMPLOYEE_DOCUMENT_TITLE"] = 'Document';
$lang["EMPLOYEE_DOCUMENT_DOCUMENTS"] = 'Documents';
$lang["EMPLOYEE_DOCUMENT_NEW"] = 'New Document';
$lang["EMPLOYEE_DOCUMENT_ACTION_NEW"] = 'new Document';
$lang["EMPLOYEE_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["EMPLOYEE_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["EMPLOYEE_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["EMPLOYEE_DOCUMENT_FILESIZE"] = 'Filesize';

$lang["EMPLOYEE_DOCUMENT_HELP"] = 'manual_mitarbeiter_aktenmappen.pdf';

$lang["EMPLOYEE_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>