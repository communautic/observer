<?php
$employees_vdocs_name = "Documents";

$lang["EMPLOYEE_VDOC_TITLE"] = 'Document';
$lang["EMPLOYEE_VDOC_NEW"] = 'New Document';
$lang["EMPLOYEE_VDOC_TASK_NEW"] = 'New Topic';
$lang["EMPLOYEE_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["EMPLOYEE_VDOC_HELP"] = 'manual_mitarbeiter_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>