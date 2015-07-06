<?php
$evals_phonecalls_name = "Telefonate";

$lang["EVAL_PHONECALL_TITLE"] = 'Telefonat';
$lang["EVAL_PHONECALLS"] = 'Telefonate';

$lang["EVAL_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["EVAL_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["EVAL_PHONECALL_DATE"] = 'Datum';
$lang["EVAL_PHONECALL_TIME_START"] = 'Start';
$lang["EVAL_PHONECALL_TIME_END"] = 'Ende';

$lang["EVAL_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["EVAL_PHONECALL_TYPE"] = 'Telefonieart';
$lang["EVAL_PHONECALL_GOALS"] = 'Notiz';

$lang["EVAL_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["EVAL_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["EVAL_PHONECALL_HELP"] = 'manual_mitarbeiter_telefonate.pdf';

$lang["EVAL_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>