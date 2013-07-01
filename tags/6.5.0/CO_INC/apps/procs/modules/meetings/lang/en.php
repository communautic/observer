<?php
$procs_meetings_name = "Meetings";

$lang["PROC_MEETING_TITLE"] = 'Meeting';
$lang["PROC_MEETINGS"] = 'Meetings';

$lang["PROC_MEETING_NEW"] = 'New Meeting';
$lang["PROC_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["PROC_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PROC_MEETING_DATE"] = 'Date';
$lang["PROC_MEETING_PLACE"] = 'Location';
$lang["PROC_MEETING_TIME_START"] = 'Start';
$lang["PROC_MEETING_TIME_END"] = 'End';

$lang["PROC_MEETING_ATTENDEES"] = 'Attendees';
$lang["PROC_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["PROC_MEETING_GOALS"] = 'Agenda';
$lang["PROC_MEETING_COPY"] = 'Copy';

$lang["PROC_MEETING_POSPONED"] = 'posponed';

$lang["PROC_MEETING_HELP"] = 'manual_prozesse_besprechungen.pdf';

$lang["PROC_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>