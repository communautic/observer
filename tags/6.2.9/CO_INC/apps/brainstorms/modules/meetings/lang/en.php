<?php
$brainstorms_meetings_name = "Meetings";

$lang["BRAINSTORM_MEETING_TITLE"] = 'Meeting';
$lang["BRAINSTORM_MEETINGS"] = 'Meetings';

$lang["BRAINSTORM_MEETING_NEW"] = 'New Meeting';
$lang["BRAINSTORM_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["BRAINSTORM_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["BRAINSTORM_MEETING_DATE"] = 'Date';
$lang["BRAINSTORM_MEETING_PLACE"] = 'Location';
$lang["BRAINSTORM_MEETING_TIME_START"] = 'Start';
$lang["BRAINSTORM_MEETING_TIME_END"] = 'End';

$lang["BRAINSTORM_MEETING_ATTENDEES"] = 'Attendees';
$lang["BRAINSTORM_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["BRAINSTORM_MEETING_GOALS"] = 'Agenda';

$lang["BRAINSTORM_MEETING_HELP"] = 'manual_prozesse_besprechungen.pdf';

$lang["BRAINSTORM_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>