<?php
$brainstorms_rosters_name = "Projektraster";

$lang["BRAINSTORM_ROSTER_TITLE"] = 'Projektraster';
$lang["BRAINSTORM_ROSTERS"] = 'Projektraster';

$lang["BRAINSTORM_ROSTER_NEW"] = 'Neues Projektraster';
$lang["BRAINSTORM_ROSTER_ACTION_NEW"] = 'neues Projektraster anlegen';
$lang["BRAINSTORM_ROSTER_COLUMN_NEW"] = 'PSP Spalten';
$lang["BRAINSTORM_ROSTER_ITEM_NEW"] = 'Neue Tätigkeit';
//define('ROSTER_RELATES_TO', 'bezogen auf');
$lang["BRAINSTORM_ROSTER_DATE"] = 'Datum';
$lang["BRAINSTORM_ROSTER_PLACE"] = 'Ort';
$lang["BRAINSTORM_ROSTER_TIME_START"] = 'Start';
$lang["BRAINSTORM_ROSTER_TIME_END"] = 'Ende';

$lang["BRAINSTORM_ROSTER_ATTENDEES"] = 'Teilnehmer';
$lang["BRAINSTORM_ROSTER_MANAGEMENT"] = 'Protokollführer';
$lang["BRAINSTORM_ROSTER_GOALS"] = 'Themen';

$lang["BRAINSTORM_ROSTER_STATUS_PLANNED"] = 'in Planung';
$lang["BRAINSTORM_ROSTER_STATUS_ON_SCHEDULE"] = 'termingerecht abgehalten';
$lang["BRAINSTORM_ROSTER_STATUS_CANCELLED"] = 'abgesagt';
$lang["BRAINSTORM_ROSTER_STATUS_POSPONED"] = 'verschoben auf';
$lang["BRAINSTORM_ROSTER_POSPONED"] = 'verschoben';

$lang["BRAINSTORM_PRINT_ROSTER"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/rosters/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>