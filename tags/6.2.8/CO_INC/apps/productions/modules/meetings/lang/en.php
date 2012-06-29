<?php
$productions_meetings_name = "Meetings";

$lang["PRODUCTION_MEETING_TITLE"] = 'Meeting';
$lang["PRODUCTION_MEETINGS"] = 'Meetings';

$lang["PRODUCTION_MEETING_NEW"] = 'New Meeting';
$lang["PRODUCTION_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["PRODUCTION_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PRODUCTION_MEETING_DATE"] = 'Date';
$lang["PRODUCTION_MEETING_PLACE"] = 'Location';
$lang["PRODUCTION_MEETING_TIME_START"] = 'Start';
$lang["PRODUCTION_MEETING_TIME_END"] = 'End';

$lang["PRODUCTION_MEETING_ATTENDEES"] = 'Attendees';
$lang["PRODUCTION_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["PRODUCTION_MEETING_GOALS"] = 'Agenda';

$lang["PRODUCTION_MEETING_STATUS_PLANNED"] = 'planned';
$lang["PRODUCTION_MEETING_STATUS_ON_SCHEDULE"] = 'on schedule';
$lang["PRODUCTION_MEETING_STATUS_CANCELLED"] = 'cancelled';
$lang["PRODUCTION_MEETING_STATUS_POSPONED"] = 'posponed to';
$lang["PRODUCTION_MEETING_POSPONED"] = 'posponed';

$lang["PRODUCTION_MEETING_HELP"] = 'manual_projekte_besprechungen.pdf';

$lang["PRODUCTION_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>