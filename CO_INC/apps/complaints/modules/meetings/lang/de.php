<?php
$complaints_meetings_name = "Besprechungen";

$lang["COMPLAINT_MEETING_TITLE"] = 'Besprechung';
$lang["COMPLAINT_MEETINGS"] = 'Besprechungen';

$lang["COMPLAINT_MEETING_NEW"] = 'Neue Besprechung';
$lang["COMPLAINT_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["COMPLAINT_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["COMPLAINT_MEETING_DATE"] = 'Datum';
$lang["COMPLAINT_MEETING_PLACE"] = 'Ort';
$lang["COMPLAINT_MEETING_TIME_START"] = 'Start';
$lang["COMPLAINT_MEETING_TIME_END"] = 'Ende';

$lang["COMPLAINT_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["COMPLAINT_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["COMPLAINT_MEETING_GOALS"] = 'Themen';

$lang["COMPLAINT_MEETING_POSPONED"] = 'verschoben';

$lang["COMPLAINT_MEETING_HELP"] = 'manual_reklamationen_besprechungen.pdf';

$lang["COMPLAINT_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>