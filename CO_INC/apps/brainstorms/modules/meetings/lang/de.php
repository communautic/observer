<?php
$brainstorms_meetings_name = "Besprechungen";

$lang["BRAINSTORM_MEETING_TITLE"] = 'Besprechung';
$lang["BRAINSTORM_MEETINGS"] = 'Besprechungen';

$lang["BRAINSTORM_MEETING_NEW"] = 'Neue Besprechung';
$lang["BRAINSTORM_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["BRAINSTORM_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["BRAINSTORM_MEETING_DATE"] = 'Datum';
$lang["BRAINSTORM_MEETING_PLACE"] = 'Ort';
$lang["BRAINSTORM_MEETING_TIME_START"] = 'Start';
$lang["BRAINSTORM_MEETING_TIME_END"] = 'Ende';

$lang["BRAINSTORM_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["BRAINSTORM_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["BRAINSTORM_MEETING_GOALS"] = 'Themen';
$lang["BRAINSTORM_MEETING_COPY"] = 'Protokollkopie';

$lang["BRAINSTORM_MEETING_POSPONED"] = 'verschoben';

$lang["BRAINSTORM_MEETING_HELP"] = 'manual_prozesse_besprechungen.pdf';

$lang["BRAINSTORM_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>