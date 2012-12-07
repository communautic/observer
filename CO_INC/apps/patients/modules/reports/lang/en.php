<?php
$patients_reports_name = "Reports";

$lang["PATIENT_REPORT_TITLE"] = 'Report';
$lang["PATIENT_REPORTS"] = 'Reports';

$lang["PATIENT_REPORT_NEW"] = 'new Report';
$lang["PATIENT_REPORT_ACTION_NEW"] = 'create new Report';

$lang["PATIENT_REPORT_TREATMENT"] = 'Treatment';

$lang["PATIENT_REPORT_DATE"] = 'Date';

$lang["PATIENT_REPORT_DOCTOR_DIAGNOSE"] = 'Medical Diagnosis';
$lang["PATIENT_REPORT_TREATMENT_DATE"] = 'Diagnosis Date';
$lang["PATIENT_REPORT_MANAGEMENT"] = 'Therapist';

$lang["PATIENT_REPORT_DOCTOR"] = 'Doctor';
$lang["PATIENT_REPORT_PROTOCOL2"] = 'Prescriptions';

$lang["PATIENT_REPORT_TEXTFIELD1"] = 'Clinical course';
$lang["PATIENT_REPORT_TEXTFIELD2"] = 'Recommendations';
$lang["PATIENT_REPORT_FEEDBACK"] = 'Feedback';

$lang["PATIENT_REPORT_HELP"] = 'manual_patienten_therapieberichte.pdf';

$lang["PATIENT_PRINT_REPORT"] = 'report.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/reports/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>