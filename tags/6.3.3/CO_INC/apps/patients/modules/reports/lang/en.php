<?php
$patients_reports_name = "Reports";

$lang["PATIENT_REPORT_TITLE"] = 'Report';
$lang["PATIENT_REPORTS"] = 'Reports';

$lang["PATIENT_REPORT_NEW"] = 'New Report';
$lang["PATIENT_REPORT_ACTION_NEW"] = 'new Report';

$lang["PATIENT_REPORT_DATE"] = 'Date';
$lang["PATIENT_REPORT_TIME_START"] = 'Start';
$lang["PATIENT_REPORT_TIME_END"] = 'End';

$lang["PATIENT_REPORT_MANAGEMENT"] = 'With';
$lang["PATIENT_REPORT_TYPE"] = 'Call type';
$lang["PATIENT_REPORT_GOALS"] = 'Agenda';

$lang["PATIENT_REPORT_STATUS_OUTGOING"] = 'incoming';
$lang["PATIENT_REPORT_STATUS_ON_INCOMING"] = 'outgoing';

$lang["PATIENT_REPORT_HELP"] = 'manual_mitarbeiter_telefonate.pdf';

$lang["PATIENT_PRINT_REPORT"] = 'report.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/reports/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>