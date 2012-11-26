<?php
$patients_reports_name = "Therapieberichte";

$lang["PATIENT_REPORT_TITLE"] = 'Therapiebericht';
$lang["PATIENT_REPORTS"] = 'Therapieberichte';

$lang["PATIENT_REPORT_NEW"] = 'Neuer Therapiebericht';
$lang["PATIENT_REPORT_ACTION_NEW"] = 'neuen Therapiebericht anlegen';

$lang["PATIENT_REPORT_TREATMENT"] = 'Behandlung';

$lang["PATIENT_REPORT_DATE"] = 'Datum';

$lang["PATIENT_REPORT_DOCTOR_DIAGNOSE"] = 'Arztdiagnose';
$lang["PATIENT_REPORT_TREATMENT_DATE"] = 'Befundungsdatum';
$lang["PATIENT_REPORT_MANAGEMENT"] = 'Therapieverantwortung';

$lang["PATIENT_REPORT_DOCTOR"] = 'Arzt';
$lang["PATIENT_REPORT_PROTOCOL2"] = 'Verordnungen';

$lang["PATIENT_REPORT_TEXTFIELD1"] = 'Verlauf';
$lang["PATIENT_REPORT_TEXTFIELD2"] = 'Empfehlung';
$lang["PATIENT_REPORT_FEEDBACK"] = 'Rückmeldung';

$lang["PATIENT_REPORT_HELP"] = 'manual_mitarbeiter_telefonate.pdf';

$lang["PATIENT_PRINT_REPORT"] = 'therapiebericht.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/reports/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>