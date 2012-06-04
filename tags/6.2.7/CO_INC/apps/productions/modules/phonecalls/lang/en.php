<?php
$productions_phonecalls_name = "Phonecalls";

$lang["PRODUCTION_PHONECALL_TITLE"] = 'Phonecall';
$lang["PRODUCTION_PHONECALLS"] = 'Phonecalls';

$lang["PRODUCTION_PHONECALL_NEW"] = 'New Phonecall';
$lang["PRODUCTION_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["PRODUCTION_PHONECALL_DATE"] = 'Date';
$lang["PRODUCTION_PHONECALL_TIME_START"] = 'Start';
$lang["PRODUCTION_PHONECALL_TIME_END"] = 'End';

$lang["PRODUCTION_PHONECALL_MANAGEMENT"] = 'With';
$lang["PRODUCTION_PHONECALL_GOALS"] = 'Agenda';

$lang["PRODUCTION_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["PRODUCTION_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["PRODUCTION_PHONECALL_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["PRODUCTION_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>