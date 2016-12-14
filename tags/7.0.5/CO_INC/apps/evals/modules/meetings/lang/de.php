<?php
$evals_meetings_name = "Besprechungen";

$lang["EVAL_MEETING_TITLE"] = 'Besprechung';
$lang["EVAL_MEETINGS"] = 'Besprechungen';

$lang["EVAL_MEETING_NEW"] = 'Neue Besprechung';
$lang["EVAL_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["EVAL_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["EVAL_MEETING_DATE"] = 'Datum';
$lang["EVAL_MEETING_PLACE"] = 'Ort';
$lang["EVAL_MEETING_TIME_START"] = 'Start';
$lang["EVAL_MEETING_TIME_END"] = 'Ende';

$lang["EVAL_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["EVAL_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["EVAL_MEETING_GOALS"] = 'Themen';
$lang["EVAL_MEETING_COPY"] = 'Protokollkopie';


$lang["EVAL_MEETING_POSPONED"] = 'verschoben';

$lang["EVAL_MEETING_HELP"] = 'manual_mitarbeiter_besprechungen.pdf';

$lang["EVAL_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>