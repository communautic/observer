<?php
$patients_reports_name = "Therapieberichte";

$lang["PATIENT_REPORT_TITLE"] = 'Therapiebericht';
$lang["PATIENT_REPORTS"] = 'Therapieberichte';

$lang["PATIENT_REPORT_NEW"] = 'Neuer Therapiebericht';
$lang["PATIENT_REPORT_ACTION_NEW"] = 'neuen Therapiebericht anlegen';

$lang["PATIENT_REPORT_TREATMENT"] = 'Behandlung';

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