<?php
$employees_meetings_name = "Meetings";

$lang["EMPLOYEE_MEETING_TITLE"] = 'Meeting';
$lang["EMPLOYEE_MEETINGS"] = 'Meetings';

$lang["EMPLOYEE_MEETING_NEW"] = 'New Meeting';
$lang["EMPLOYEE_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["EMPLOYEE_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["EMPLOYEE_MEETING_DATE"] = 'Date';
$lang["EMPLOYEE_MEETING_PLACE"] = 'Location';
$lang["EMPLOYEE_MEETING_TIME_START"] = 'Start';
$lang["EMPLOYEE_MEETING_TIME_END"] = 'End';

$lang["EMPLOYEE_MEETING_ATTENDEES"] = 'Attendees';
$lang["EMPLOYEE_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["EMPLOYEE_MEETING_GOALS"] = 'Agenda';

$lang["EMPLOYEE_MEETING_POSPONED"] = 'posponed';


$lang["EMPLOYEE_MEETING_HELP"] = 'manual_reklamationen_besprechungen.pdf';

$lang["EMPLOYEE_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>