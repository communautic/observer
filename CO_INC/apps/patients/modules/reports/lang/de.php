<?php
$patients_reports_name = "Berichte";

$lang["PATIENT_REPORT_TITLE"] = 'Bericht';
$lang["PATIENT_REPORTS"] = 'Berichte';

$lang["PATIENT_REPORT_NEW"] = 'Neuer Bericht';
$lang["PATIENT_REPORT_ACTION_NEW"] = 'neuen Bericht anlegen';

$lang["PATIENT_REPORT_DATE"] = 'Datum';
$lang["PATIENT_REPORT_TIME_START"] = 'Start';
$lang["PATIENT_REPORT_TIME_END"] = 'Ende';

$lang["PATIENT_REPORT_MANAGEMENT"] = 'Gesprächspartner';
$lang["PATIENT_REPORT_TYPE"] = 'Telefonieart';
$lang["PATIENT_REPORT_GOALS"] = 'Notiz';

$lang["PATIENT_REPORT_STATUS_OUTGOING"] = 'Outgoing';
$lang["PATIENT_REPORT_STATUS_ON_INCOMING"] = 'Incoming';

$lang["PATIENT_REPORT_HELP"] = 'manual_mitarbeiter_telefonate.pdf';

$lang["PATIENT_PRINT_REPORT"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/reports/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>