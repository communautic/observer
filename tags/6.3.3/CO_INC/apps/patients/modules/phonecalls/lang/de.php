<?php
$patients_phonecalls_name = "Telefonate";

$lang["PATIENT_PHONECALL_TITLE"] = 'Telefonat';
$lang["PATIENT_PHONECALLS"] = 'Telefonate';

$lang["PATIENT_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["PATIENT_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["PATIENT_PHONECALL_DATE"] = 'Datum';
$lang["PATIENT_PHONECALL_TIME_START"] = 'Start';
$lang["PATIENT_PHONECALL_TIME_END"] = 'Ende';

$lang["PATIENT_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["PATIENT_PHONECALL_TYPE"] = 'Telefonieart';
$lang["PATIENT_PHONECALL_GOALS"] = 'Notiz';

$lang["PATIENT_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["PATIENT_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["PATIENT_PHONECALL_HELP"] = 'manual_mitarbeiter_telefonate.pdf';

$lang["PATIENT_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>