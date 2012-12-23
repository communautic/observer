<?php
$projects_meetings_name = "Besprechungen";

$lang["PROJECT_MEETING_TITLE"] = 'Besprechung';
$lang["PROJECT_MEETINGS"] = 'Besprechungen';

$lang["PROJECT_MEETING_NEW"] = 'Neue Besprechung';
$lang["PROJECT_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["PROJECT_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PROJECT_MEETING_DATE"] = 'Datum';
$lang["PROJECT_MEETING_PLACE"] = 'Ort';
$lang["PROJECT_MEETING_TIME_START"] = 'Start';
$lang["PROJECT_MEETING_TIME_END"] = 'Ende';

$lang["PROJECT_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["PROJECT_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["PROJECT_MEETING_GOALS"] = 'Themen';
$lang["PROJECT_MEETING_COPY"] = 'Protokollkopie';

$lang["PROJECT_MEETING_POSPONED"] = 'verschoben';

$lang["PROJECT_MEETING_HELP"] = 'manual_projekte_besprechungen.pdf';

$lang["PROJECT_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>