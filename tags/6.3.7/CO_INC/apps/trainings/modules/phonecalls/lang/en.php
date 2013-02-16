<?php
$trainings_phonecalls_name = "Phonecalls";

$lang["TRAINING_PHONECALL_TITLE"] = 'Phonecall';
$lang["TRAINING_PHONECALLS"] = 'Phonecalls';

$lang["TRAINING_PHONECALL_NEW"] = 'New Phonecall';
$lang["TRAINING_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["TRAINING_PHONECALL_DATE"] = 'Date';
$lang["TRAINING_PHONECALL_TIME_START"] = 'Start';
$lang["TRAINING_PHONECALL_TIME_END"] = 'End';

$lang["TRAINING_PHONECALL_MANAGEMENT"] = 'With';
$lang["TRAINING_PHONECALL_TYPE"] = 'Call type';
$lang["TRAINING_PHONECALL_GOALS"] = 'Agenda';

$lang["TRAINING_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["TRAINING_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["TRAINING_PHONECALL_HELP"] = 'manual_reklamationen_telefonate.pdf';

$lang["TRAINING_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>