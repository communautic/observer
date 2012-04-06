<?php
$complaints_phonecalls_name = "Phonecalls";

$lang["COMPLAINT_PHONECALL_TITLE"] = 'Phonecall';
$lang["COMPLAINT_PHONECALLS"] = 'Phonecalls';

$lang["COMPLAINT_PHONECALL_NEW"] = 'New Phonecall';
$lang["COMPLAINT_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["COMPLAINT_PHONECALL_DATE"] = 'Date';
$lang["COMPLAINT_PHONECALL_TIME_START"] = 'Start';
$lang["COMPLAINT_PHONECALL_TIME_END"] = 'End';

$lang["COMPLAINT_PHONECALL_MANAGEMENT"] = 'With';
$lang["COMPLAINT_PHONECALL_GOALS"] = 'Agenda';

$lang["COMPLAINT_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["COMPLAINT_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["COMPLAINT_PHONECALL_HELP"] = 'manual_reklamationen_telefonate.pdf';

$lang["COMPLAINT_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>