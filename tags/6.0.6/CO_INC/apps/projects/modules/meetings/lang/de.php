<?php
$meetings_name = "Besprechungen";

$lang["MEETING_TITLE"] = 'Besprechung';
$lang["MEETING_NEW"] = 'Neue Besprechung';
$lang["MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["MEETING_DATE"] = 'Datum';
$lang["MEETING_PLACE"] = 'Ort';
$lang["MEETING_TIME_START"] = 'Start';
$lang["MEETING_TIME_END"] = 'Ende';

$lang["MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["MEETING_GOALS"] = 'Themen';

$lang["MEETING_STATUS_PLANNED"] = 'in Planung';
$lang["MEETING_STATUS_ON_SCHEDULE"] = 'termingerecht abgehalten';
$lang["MEETING_STATUS_CANCELLED"] = 'abgesagt';
$lang["MEETING_STATUS_POSPONED"] = 'verschoben auf';
$lang["MEETING_POSPONED"] = 'verschoben';

$lang["PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>