<?php
$evals_phonecalls_name = "Phonecalls";

$lang["EVAL_PHONECALL_TITLE"] = 'Phonecall';
$lang["EVAL_PHONECALLS"] = 'Phonecalls';

$lang["EVAL_PHONECALL_NEW"] = 'New Phonecall';
$lang["EVAL_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["EVAL_PHONECALL_DATE"] = 'Date';
$lang["EVAL_PHONECALL_TIME_START"] = 'Start';
$lang["EVAL_PHONECALL_TIME_END"] = 'End';

$lang["EVAL_PHONECALL_MANAGEMENT"] = 'With';
$lang["EVAL_PHONECALL_TYPE"] = 'Call type';
$lang["EVAL_PHONECALL_GOALS"] = 'Agenda';

$lang["EVAL_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["EVAL_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["EVAL_PHONECALL_HELP"] = 'manual_mitarbeiter_telefonate.pdf';

$lang["EVAL_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>