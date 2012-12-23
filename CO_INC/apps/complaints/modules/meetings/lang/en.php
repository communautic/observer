<?php
$complaints_meetings_name = "Meetings";

$lang["COMPLAINT_MEETING_TITLE"] = 'Meeting';
$lang["COMPLAINT_MEETINGS"] = 'Meetings';

$lang["COMPLAINT_MEETING_NEW"] = 'New Meeting';
$lang["COMPLAINT_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["COMPLAINT_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["COMPLAINT_MEETING_DATE"] = 'Date';
$lang["COMPLAINT_MEETING_PLACE"] = 'Location';
$lang["COMPLAINT_MEETING_TIME_START"] = 'Start';
$lang["COMPLAINT_MEETING_TIME_END"] = 'End';

$lang["COMPLAINT_MEETING_ATTENDEES"] = 'Attendees';
$lang["COMPLAINT_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["COMPLAINT_MEETING_GOALS"] = 'Agenda';
$lang["COMPLAINT_MEETING_COPY"] = 'Copy';

$lang["COMPLAINT_MEETING_POSPONED"] = 'posponed';


$lang["COMPLAINT_MEETING_HELP"] = 'manual_reklamationen_besprechungen.pdf';

$lang["COMPLAINT_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>