<?php
$projects_phonecalls_name = "Phonecalls";

$lang["PROJECT_PHONECALL_TITLE"] = 'Phonecall';
$lang["PROJECT_PHONECALLS"] = 'Phonecalls';

$lang["PROJECT_PHONECALL_NEW"] = 'New Phonecall';
$lang["PROJECT_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["PROJECT_PHONECALL_DATE"] = 'Date';
$lang["PROJECT_PHONECALL_TIME_START"] = 'Start';
$lang["PROJECT_PHONECALL_TIME_END"] = 'End';

$lang["PROJECT_PHONECALL_MANAGEMENT"] = 'With';
$lang["PROJECT_PHONECALL_TYPE"] = 'Call type';
$lang["PROJECT_PHONECALL_GOALS"] = 'Agenda';

$lang["PROJECT_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["PROJECT_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["PROJECT_PHONECALL_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["PROJECT_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>