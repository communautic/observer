<?php
$projects_meetings_name = "Meetings";

$lang["PROJECT_MEETING_TITLE"] = 'Meeting';
$lang["PROJECT_MEETINGS"] = 'Meetings';

$lang["PROJECT_MEETING_NEW"] = 'New Meeting';
$lang["PROJECT_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["PROJECT_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PROJECT_MEETING_DATE"] = 'Date';
$lang["PROJECT_MEETING_PLACE"] = 'Location';
$lang["PROJECT_MEETING_TIME_START"] = 'Start';
$lang["PROJECT_MEETING_TIME_END"] = 'End';

$lang["PROJECT_MEETING_ATTENDEES"] = 'Attendees';
$lang["PROJECT_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["PROJECT_MEETING_GOALS"] = 'Agenda';

$lang["PROJECT_MEETING_POSPONED"] = 'postponed';

$lang["PROJECT_MEETING_HELP"] = 'manual_projekte_besprechungen.pdf';

$lang["PROJECT_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>