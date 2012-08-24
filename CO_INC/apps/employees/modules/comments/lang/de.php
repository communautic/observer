<?php
$employees_comments_name = "Leistungskommentare";

$lang["EMPLOYEE_COMMENT_TITLE"] = 'Leistungskommentar';
$lang["EMPLOYEE_COMMENTS"] = 'Leistungskommentare';

$lang["EMPLOYEE_COMMENT_NEW"] = 'Neuer Leistungskommentar';
$lang["EMPLOYEE_COMMENT_ACTION_NEW"] = 'neuen Leistungskommentar anlegen';

$lang["EMPLOYEE_COMMENT_DATE"] = 'Datum';
$lang["EMPLOYEE_COMMENT_TIME_START"] = 'Start';
$lang["EMPLOYEE_COMMENT_TIME_END"] = 'Ende';

$lang["EMPLOYEE_COMMENT_MANAGEMENT"] = 'Verfasser';
$lang["EMPLOYEE_COMMENT_TYPE"] = 'Telefonieart';
$lang["EMPLOYEE_COMMENT_GOALS"] = 'Notiz';

$lang["EMPLOYEE_COMMENT_HELP"] = 'manual_mitarbeiter_leistungskommentare.pdf';

$lang["EMPLOYEE_PRINT_COMMENT"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/comments/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>