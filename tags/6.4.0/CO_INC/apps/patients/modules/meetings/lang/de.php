<?php
$patients_meetings_name = "Besprechungen";

$lang["PATIENT_MEETING_TITLE"] = 'Besprechung';
$lang["PATIENT_MEETINGS"] = 'Besprechungen';

$lang["PATIENT_MEETING_NEW"] = 'Neue Besprechung';
$lang["PATIENT_MEETING_ACTION_NEW"] = 'neue Besprechung anlegen';
$lang["PATIENT_MEETING_TASK_NEW"] = 'Neues Thema';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PATIENT_MEETING_DATE"] = 'Datum';
$lang["PATIENT_MEETING_PLACE"] = 'Ort';
$lang["PATIENT_MEETING_TIME_START"] = 'Start';
$lang["PATIENT_MEETING_TIME_END"] = 'Ende';

$lang["PATIENT_MEETING_ATTENDEES"] = 'Teilnehmer';
$lang["PATIENT_MEETING_MANAGEMENT"] = 'Protokollführer';
$lang["PATIENT_MEETING_GOALS"] = 'Themen';
$lang["PATIENT_MEETING_COPY"] = 'Protokollkopie';


$lang["PATIENT_MEETING_POSPONED"] = 'verschoben';

$lang["PATIENT_MEETING_HELP"] = 'manual_patienten_besprechungen.pdf';

$lang["PATIENT_PRINT_MEETING"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/meetings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>