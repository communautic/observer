<?php
$complaints_phonecalls_name = "Telefonate";

$lang["COMPLAINT_PHONECALL_TITLE"] = 'Telefonat';
$lang["COMPLAINT_PHONECALLS"] = 'Telefonate';

$lang["COMPLAINT_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["COMPLAINT_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["COMPLAINT_PHONECALL_DATE"] = 'Datum';
$lang["COMPLAINT_PHONECALL_TIME_START"] = 'Start';
$lang["COMPLAINT_PHONECALL_TIME_END"] = 'Ende';

$lang["COMPLAINT_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["COMPLAINT_PHONECALL_GOALS"] = 'Themen';

$lang["COMPLAINT_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["COMPLAINT_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["COMPLAINT_PHONECALL_HELP"] = 'manual_reklamationen_telefonate.pdf';

$lang["COMPLAINT_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>