<?php
$patients_reports_name = "Berichte";

$lang["PATIENT_REPORT_TITLE"] = 'Bericht';
$lang["PATIENT_REPORTS"] = 'Berichte';

$lang["PATIENT_REPORT_NEW"] = 'Neuer Bericht';
$lang["PATIENT_REPORT_ACTION_NEW"] = 'neuen Bericht anlegen';

$lang["PATIENT_REPORT_TREATMENT"] = 'Behandlung';

$lang["PATIENT_REPORT_DATE"] = 'Datum';

$lang["PATIENT_REPORT_DOCTOR_DIAGNOSE"] = 'Diagnose';
$lang["PATIENT_REPORT_TREATMENT_METHOD"] = 'Behandlungsmethode';
$lang["PATIENT_REPORT_TREATMENT_DATE"] = 'Befundungsdatum';
$lang["PATIENT_REPORT_MANAGEMENT"] = 'Betreuung';

$lang["PATIENT_REPORT_DOCTOR"] = 'Arzt';
$lang["PATIENT_REPORT_PROTOCOL2"] = 'Verordnungen';

$lang["PATIENT_REPORT_TEXTFIELD1"] = 'Anmerkung';
$lang["PATIENT_REPORT_TEXTFIELD2"] = 'Empfehlung';
$lang["PATIENT_REPORT_FEEDBACK"] = 'Rückmeldung';
$lang["PATIENT_REPORT_PRINT_GREETING"] = 'Mit freundlichen Grüßen';

$lang["PATIENT_REPORT_HELP"] = 'manual_patienten_berichte.pdf';

$lang["PATIENT_PRINT_REPORT"] = 'bericht.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/reports/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>