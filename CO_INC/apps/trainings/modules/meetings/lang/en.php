<?php
$trainings_meetings_name = "Meetings";

$lang["TRAINING_MEETING_TITLE"] = 'Meeting';
$lang["TRAINING_MEETINGS"] = 'Meetings';

$lang["TRAINING_MEETING_NEW"] = 'New Meeting';
$lang["TRAINING_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["TRAINING_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["TRAINING_MEETING_DATE"] = 'Date';
$lang["TRAINING_MEETING_PLACE"] = 'Location';
$lang["TRAINING_MEETING_TIME_START"] = 'Start';
$lang["TRAINING_MEETING_TIME_END"] = 'End';

$lang["TRAINING_MEETING_ATTENDEES"] = 'Attendees';
$lang["TRAINING_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["TRAINING_MEETING_GOALS"] = 'Agenda';
$lang["TRAINING_MEETING_COPY"] = 'Copy';

$lang["TRAINING_MEETING_POSPONED"] = 'posponed';


$lang["TRAINING_MEETING_HELP"] = 'manual_trainings_besprechungen.pdf';

$lang["TRAINING_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>