<?php
$patients_phonecalls_name = "Phonecalls";

$lang["PATIENT_PHONECALL_TITLE"] = 'Phonecall';
$lang["PATIENT_PHONECALLS"] = 'Phonecalls';

$lang["PATIENT_PHONECALL_NEW"] = 'New Phonecall';
$lang["PATIENT_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["PATIENT_PHONECALL_DATE"] = 'Date';
$lang["PATIENT_PHONECALL_TIME_START"] = 'Start';
$lang["PATIENT_PHONECALL_TIME_END"] = 'End';

$lang["PATIENT_PHONECALL_MANAGEMENT"] = 'With';
$lang["PATIENT_PHONECALL_TYPE"] = 'Call type';
$lang["PATIENT_PHONECALL_GOALS"] = 'Agenda';

$lang["PATIENT_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["PATIENT_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["PATIENT_PHONECALL_HELP"] = 'manual_patienten_telefonate.pdf';

$lang["PATIENT_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>