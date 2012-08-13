<?php
$employees_meetings_name = "Besprechungen";

$lang["EMPLOYEE_MEETING_TITLE"] = 'Besprechung';
$lang["EMPLOYEE_MEETINGS"] = 'Besprechungen';

$lang["EMPLOYEE_MEETING_NEW"] = 'Neue Besprechung';
$lang["EMPLOYEE_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["EMPLOYEE_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["EMPLOYEE_MEETING_DATE"] = 'Datum';
$lang["EMPLOYEE_MEETING_PLACE"] = 'Ort';
$lang["EMPLOYEE_MEETING_TIME_START"] = 'Start';
$lang["EMPLOYEE_MEETING_TIME_END"] = 'Ende';

$lang["EMPLOYEE_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["EMPLOYEE_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["EMPLOYEE_MEETING_GOALS"] = 'Themen';

$lang["EMPLOYEE_MEETING_POSPONED"] = 'verschoben';

$lang["EMPLOYEE_MEETING_HELP"] = 'manual_reklamationen_besprechungen.pdf';

$lang["EMPLOYEE_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>