<?php
$evals_meetings_name = "Meetings";

$lang["EVAL_MEETING_TITLE"] = 'Meeting';
$lang["EVAL_MEETINGS"] = 'Meetings';

$lang["EVAL_MEETING_NEW"] = 'New Meeting';
$lang["EVAL_MEETING_ACTION_NEW"] = 'new Meeting';
$lang["EVAL_MEETING_TASK_NEW"] = 'New Item';
//define('MEETING_RELATES_TO', 'bezogen auf');
$lang["EVAL_MEETING_DATE"] = 'Date';
$lang["EVAL_MEETING_PLACE"] = 'Location';
$lang["EVAL_MEETING_TIME_START"] = 'Start';
$lang["EVAL_MEETING_TIME_END"] = 'End';

$lang["EVAL_MEETING_ATTENDEES"] = 'Attendees';
$lang["EVAL_MEETING_MANAGEMENT"] = 'Minuted by';
$lang["EVAL_MEETING_GOALS"] = 'Agenda';
$lang["EVAL_MEETING_COPY"] = 'Copy';

$lang["EVAL_MEETING_POSPONED"] = 'posponed';


$lang["EVAL_MEETING_HELP"] = 'manual_mitarbeiter_besprechungen.pdf';

$lang["EVAL_PRINT_MEETING"] = 'meeting.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/meetings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>