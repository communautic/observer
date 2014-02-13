<?php
$patients_treatments_name = "Behandlungen";

$lang["PATIENT_TREATMENT_TITLE"] = 'Behandlung';
$lang["PATIENT_TREATMENTS"] = 'Behandlungen';

$lang["PATIENT_TREATMENT_NEW"] = 'Neue Behandlung';
$lang["PATIENT_TREATMENT_ACTION_NEW"] = 'neue Behandlung anlegen';
$lang["PATIENT_TREATMENT_TASK_NEW"] = 'Neue Sitzung';

$lang["PATIENT_TREATMENT_STATUS_PLANNED"] = 'in Befundung';
$lang["PATIENT_TREATMENT_STATUS_PLANNED_TIME"] = 'seit';
$lang["PATIENT_TREATMENT_STATUS_INPROGRESS"] = 'in Behandlung';
$lang["PATIENT_TREATMENT_STATUS_INPROGRESS_TIME"] = 'seit';
$lang["PATIENT_TREATMENT_STATUS_FINISHED"] = 'abgeschlossen';
$lang["PATIENT_TREATMENT_STATUS_FINISHED_TIME"] = 'am';
$lang["PATIENT_TREATMENT_STATUS_STOPPED"] = 'abgebrochen';
$lang["PATIENT_TREATMENT_STATUS_STOPPED_TIME"] = 'am';

$lang["PATIENT_TREATMENT_DURATION"] = 'Behandlungsdauer';
$lang["PATIENT_TREATMENT_DATE"] = 'Befundungsdatum';
$lang["PATIENT_TREATMENT_DOCTOR"] = 'Arzt';
$lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"] = 'Arztdiagnose';
$lang["PATIENT_TREATMENT_DESCRIPTION"] = 'Beschreibung';
$lang["PATIENT_TREATMENT_PROTOCOL2"] = 'Verordnung';

$lang["PATIENT_TREATMENT_AMOUNT"] = 'Kosten';
$lang["PATIENT_TREATMENT_DISCOUNT"] = 'Rabattierung';
$lang["PATIENT_TREATMENT_DISCOUNT_SHORT"] = 'Rabatt';
$lang["PATIENT_TREATMENT_VAT"] = 'Mehrwertsteuer';
$lang["PATIENT_TREATMENT_VAT_SHORT"] = 'Mwst';

$lang["PATIENT_TREATMENT_DIAGNOSE"] = 'Befundung';
$lang["PATIENT_TREATMENT_DIAGNOSES"] = 'Befundungen';
$lang["PATIENT_TREATMENT_PLAN"] = 'Behandlungsplan';

$lang["PATIENT_TREATMENT_GOALS"] = 'Sitzungen';
$lang["PATIENT_TREATMENT_GOALS_SINGUAL"] = 'Sitzung';
$lang["PATIENT_TREATMENT_TASKS_TYPE"] = 'Behandlungsart';
$lang["PATIENT_TREATMENT_TASKS_THERAPIST"] = 'Therapeut';
$lang["PATIENT_TREATMENT_TASKS_PLACE"] = 'Behandlungsort';
$lang["PATIENT_TREATMENT_TASKS_PLACE2"] = 'Ort';
$lang["PATIENT_TREATMENT_TASKS_DATE"] = 'Datum';
$lang["PATIENT_TREATMENT_TASKS_TIME"] = 'Uhrzeit';
$lang["PATIENT_TREATMENT_TASKS_DURATION"] = 'Behandlungsdauer';

$lang["PATIENT_TREATMENT_HELP"] = 'manual_patienten_behandlungen.pdf';

$lang["PATIENT_PRINT_TREATMENT"] = 'behandlung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/treatments/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>