<?php
$procs_meetings_name = "Besprechungen";

$lang["PROC_MEETING_TITLE"] = 'Besprechung';
$lang["PROC_MEETINGS"] = 'Besprechungen';

$lang["PROC_MEETING_NEW"] = 'Neue Besprechung';
$lang["PROC_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["PROC_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PROC_MEETING_DATE"] = 'Datum';
$lang["PROC_MEETING_PLACE"] = 'Ort';
$lang["PROC_MEETING_TIME_START"] = 'Start';
$lang["PROC_MEETING_TIME_END"] = 'Ende';

$lang["PROC_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["PROC_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["PROC_MEETING_GOALS"] = 'Themen';
$lang["PROC_MEETING_COPY"] = 'Protokollkopie';

$lang["PROC_MEETING_POSPONED"] = 'verschoben';

$lang["PROC_MEETING_HELP"] = 'manual_prozesse_besprechungen.pdf';

$lang["PROC_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>