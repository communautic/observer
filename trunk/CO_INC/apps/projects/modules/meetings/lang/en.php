<?php
$meetings_name = "Meetings";

$lang["MEETING_TITLE"] = 'Meeting';
$lang["MEETING_NEW"] = 'New Meeting';
$lang["MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["MEETING_DATE"] = 'Date';
$lang["MEETING_PLACE"] = 'Location';
$lang["MEETING_TIME_START"] = 'Start';
$lang["MEETING_TIME_END"] = 'End';

$lang["MEETING_ATTENDEES"] = 'Attendees';
$lang["MEETING_MANAGEMENT"] = 'Minuted by';
$lang["MEETING_GOALS"] = 'Agenda';

$lang["MEETING_STATUS_PLANNED"] = 'planned';
$lang["MEETING_STATUS_ON_SCHEDULE"] = 'on schedule';
$lang["MEETING_STATUS_CANCELLED"] = 'cancelled';
$lang["MEETING_STATUS_POSPONED"] = 'posponed to';
$lang["MEETING_POSPONED"] = 'posponed';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>