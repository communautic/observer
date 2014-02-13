<?php
$employees_documents_name = "Files";

$lang["EMPLOYEE_DOCUMENT_TITLE"] = 'File';
$lang["EMPLOYEE_DOCUMENT_DOCUMENTS"] = 'Files';
$lang["EMPLOYEE_DOCUMENT_NEW"] = 'New File';
$lang["EMPLOYEE_DOCUMENT_ACTION_NEW"] = 'new File';
$lang["EMPLOYEE_DOCUMENT_DESCRIPTION"] = 'Description';
$lang["EMPLOYEE_DOCUMENT_UPLOAD"] = 'File / Upload';
$lang["EMPLOYEE_DOCUMENT_FILENAME"] = 'Filename/Format';
$lang["EMPLOYEE_DOCUMENT_FILESIZE"] = 'Filesize';
$lang["EMPLOYEE_DOCUMENT_FILES"] = 'Files';

$lang["EMPLOYEE_DOCUMENT_HELP"] = 'manual_mitarbeiter_aktenmappen.pdf';

$lang["EMPLOYEE_PRINT_DOCUMENT"] = 'document.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/documents/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>