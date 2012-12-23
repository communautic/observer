<?php
$clients_meetings_name = "Meetings";

$lang["CLIENT_MEETING_TITLE"] = 'Meeting';
$lang["CLIENT_MEETINGS"] = 'Meetings';

$lang["CLIENT_MEETING_NEW"] = 'New Meeting';
$lang["CLIENT_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["CLIENT_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["CLIENT_MEETING_DATE"] = 'Date';
$lang["CLIENT_MEETING_PLACE"] = 'Location';
$lang["CLIENT_MEETING_TIME_START"] = 'Start';
$lang["CLIENT_MEETING_TIME_END"] = 'End';

$lang["CLIENT_MEETING_ATTENDEES"] = 'Attendees';
$lang["CLIENT_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["CLIENT_MEETING_GOALS"] = 'Agenda';
$lang["CLIENT_MEETING_COPY"] = 'Copy';

$lang["CLIENT_MEETING_POSPONED"] = 'posponed';

$lang["CLIENT_MEETING_HELP"] = 'manual_kunden_besprechungen.pdf';

$lang["CLIENT_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>