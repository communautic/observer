<?php
$employees_vdocs_name = "Textbeiträge";

$lang["EMPLOYEE_VDOC_TITLE"] = 'Textbeitrag';
$lang["EMPLOYEE_VDOC_VDOCS"] = 'Textbeiträge';
$lang["EMPLOYEE_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["EMPLOYEE_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["EMPLOYEE_VDOC_HELP"] = 'manual_reklamationen_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>