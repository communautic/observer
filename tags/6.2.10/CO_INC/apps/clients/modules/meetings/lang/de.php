<?php
$clients_meetings_name = "Besprechungen";

$lang["CLIENT_MEETING_TITLE"] = 'Besprechung';
$lang["CLIENT_MEETINGS"] = 'Besprechungen';

$lang["CLIENT_MEETING_NEW"] = 'Neue Besprechung';
$lang["CLIENT_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["CLIENT_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["CLIENT_MEETING_DATE"] = 'Datum';
$lang["CLIENT_MEETING_PLACE"] = 'Ort';
$lang["CLIENT_MEETING_TIME_START"] = 'Start';
$lang["CLIENT_MEETING_TIME_END"] = 'Ende';

$lang["CLIENT_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["CLIENT_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["CLIENT_MEETING_GOALS"] = 'Themen';

$lang["CLIENT_MEETING_POSPONED"] = 'verschoben';

$lang["CLIENT_MEETING_HELP"] = 'manual_kunden_besprechungen.pdf';

$lang["CLIENT_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>