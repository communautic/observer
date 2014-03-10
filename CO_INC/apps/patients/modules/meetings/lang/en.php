<?php
$patients_meetings_name = "Meetings";

$lang["PATIENT_MEETING_TITLE"] = 'Meeting';
$lang["PATIENT_MEETINGS"] = 'Meetings';

$lang["PATIENT_MEETING_NEW"] = 'New Meeting';
$lang["PATIENT_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["PATIENT_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["PATIENT_MEETING_DATE"] = 'Date';
$lang["PATIENT_MEETING_PLACE"] = 'Location';
$lang["PATIENT_MEETING_TIME_START"] = 'Start';
$lang["PATIENT_MEETING_TIME_END"] = 'End';

$lang["PATIENT_MEETING_ATTENDEES"] = 'Attendees';
$lang["PATIENT_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["PATIENT_MEETING_GOALS"] = 'Agenda';
$lang["PATIENT_MEETING_COPY"] = 'Copy';

$lang["PATIENT_MEETING_POSPONED"] = 'posponed';


$lang["PATIENT_MEETING_HELP"] = 'manual_patients_meetings.pdf';

$lang["PATIENT_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>