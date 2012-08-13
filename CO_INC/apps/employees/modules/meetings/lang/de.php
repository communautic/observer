<?php
$employees_objectives_name = "Zielvereinbarungen";

$lang["EMPLOYEE_OBJECTIVE_TITLE"] = 'Zielvereinbarung';
$lang["EMPLOYEE_OBJECTIVES"] = 'Zielvereinbarungen';

$lang["EMPLOYEE_OBJECTIVE_NEW"] = 'Neue Zielvereinbarung';
$lang["EMPLOYEE_OBJECTIVE_ACTION_NEW"] = 'neue Zielvereinbarung anlegen';
$lang["EMPLOYEE_OBJECTIVE_TASK_NEW"] = 'Neues Thema';
//define('OBJECTIVE_RELATES_TO', 'bezogen auf');
$lang["EMPLOYEE_OBJECTIVE_DATE"] = 'Datum';
$lang["EMPLOYEE_OBJECTIVE_PLACE"] = 'Ort';
$lang["EMPLOYEE_OBJECTIVE_TIME_START"] = 'Start';
$lang["EMPLOYEE_OBJECTIVE_TIME_END"] = 'Ende';

$lang["EMPLOYEE_OBJECTIVE_ATTENDEES"] = 'Teilnehmer';
$lang["EMPLOYEE_OBJECTIVE_MANAGEMENT"] = 'Protokollführer';
$lang["EMPLOYEE_OBJECTIVE_GOALS"] = 'Themen';

$lang["EMPLOYEE_OBJECTIVE_POSPONED"] = 'verschoben';

$lang["EMPLOYEE_OBJECTIVE_HELP"] = 'manual_reklamationen_besprechungen.pdf';

$lang["EMPLOYEE_PRINT_OBJECTIVE"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/objectives/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>