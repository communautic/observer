<?php
$trainings_meetings_name = "Besprechungen";

$lang["TRAINING_MEETING_TITLE"] = 'Besprechung';
$lang["TRAINING_MEETINGS"] = 'Besprechungen';

$lang["TRAINING_MEETING_NEW"] = 'Neue Besprechung';
$lang["TRAINING_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["TRAINING_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["TRAINING_MEETING_DATE"] = 'Datum';
$lang["TRAINING_MEETING_PLACE"] = 'Ort';
$lang["TRAINING_MEETING_TIME_START"] = 'Start';
$lang["TRAINING_MEETING_TIME_END"] = 'Ende';

$lang["TRAINING_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["TRAINING_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["TRAINING_MEETING_GOALS"] = 'Themen';
$lang["TRAINING_MEETING_COPY"] = 'Protokollkopie';

$lang["TRAINING_MEETING_POSPONED"] = 'verschoben';

$lang["TRAINING_MEETING_HELP"] = 'manual_trainings_besprechungen.pdf';

$lang["TRAINING_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>