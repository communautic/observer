<?php
$trainings_feedbacks_name = "Feedbacks";

$lang["TRAINING_FEEDBACK_TITLE"] = 'Feedback';
$lang["TRAINING_FEEDBACKS"] = 'Feedbacks';

$lang["TRAINING_FEEDBACK_NEW"] = 'New Feedback';
$lang["TRAINING_FEEDBACK_ACTION_NEW"] = 'new Feedback';
$lang["TRAINING_FEEDBACK_TASK_NEW"] = 'New Item';
//define('FEEDBACK_RELATES_TO', 'bezogen auf');
$lang["TRAINING_FEEDBACK_DATE"] = 'Date';
$lang["TRAINING_FEEDBACK_PLACE"] = 'Location';
$lang["TRAINING_FEEDBACK_TIME_START"] = 'Start';
$lang["TRAINING_FEEDBACK_TIME_END"] = 'End';

$lang["TRAINING_FEEDBACK_ATTENDEES"] = 'Attendees';
$lang["TRAINING_FEEDBACK_MANAGEMENT"] = 'Minuted by';
$lang["TRAINING_FEEDBACK_GOALS"] = 'Agenda';

$lang["TRAINING_FEEDBACK_POSPONED"] = 'posponed';


$lang["TRAINING_FEEDBACK_HELP"] = 'manual_feedbacks_zielvereinbarungen.pdf';

$lang["TRAINING_PRINT_FEEDBACK"] = 'feedback.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/feedbacks/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>