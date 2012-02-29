<?php
$productions_meetings_name = "Besprechungen";

$lang["PRODUCTION_MEETING_TITLE"] = 'Besprechung';
$lang["PRODUCTION_MEETINGS"] = 'Besprechungen';

$lang["PRODUCTION_MEETING_NEW"] = 'Neue Besprechung';
$lang["PRODUCTION_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["PRODUCTION_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PRODUCTION_MEETING_DATE"] = 'Datum';
$lang["PRODUCTION_MEETING_PLACE"] = 'Ort';
$lang["PRODUCTION_MEETING_TIME_START"] = 'Start';
$lang["PRODUCTION_MEETING_TIME_END"] = 'Ende';

$lang["PRODUCTION_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["PRODUCTION_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["PRODUCTION_MEETING_GOALS"] = 'Themen';

$lang["PRODUCTION_MEETING_STATUS_PLANNED"] = 'in Planung';
$lang["PRODUCTION_MEETING_STATUS_ON_SCHEDULE"] = 'termingerecht abgehalten';
$lang["PRODUCTION_MEETING_STATUS_CANCELLED"] = 'abgesagt';
$lang["PRODUCTION_MEETING_STATUS_POSPONED"] = 'verschoben auf';
$lang["PRODUCTION_MEETING_POSPONED"] = 'verschoben';

$lang["PRODUCTION_MEETING_HELP"] = 'manual_projekte_besprechungen.pdf';

$lang["PRODUCTION_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>