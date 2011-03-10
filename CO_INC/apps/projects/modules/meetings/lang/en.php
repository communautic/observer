<?php
$meetings_name = "Meetings";

$lang["MEETING_TITLE"] = 'Meeting';
$lang["MEETING_NEW"] = 'New Meeting';
$lang["MEETING_TASK_NEW"] = 'New Topic';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["MEETING_DATE"] = 'Date';
$lang["MEETING_PLACE"] = 'Place';
$lang["MEETING_TIME_START"] = 'Start';
$lang["MEETING_TIME_END"] = 'End';

$lang["MEETING_ATTENDEES"] = 'Attendees';
$lang["MEETING_MANAGEMENT"] = 'Recorder';
$lang["MEETING_GOALS"] = 'Topics';

$lang["MEETING_STATUS_PLANNED"] = 'planned';
$lang["MEETING_STATUS_ON_SCHEDULE"] = 'held on time';
$lang["MEETING_STATUS_CANCELLED"] = 'cancelled';
$lang["MEETING_STATUS_POSPONED"] = 'posponed to';
$lang["MEETING_POSPONED"] = 'posponed';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>