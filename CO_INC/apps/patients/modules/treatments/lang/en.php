<?php
$patients_treatments_name = "Treatments";

$lang["PATIENT_TREATMENT_TITLE"] = 'Treatment';
$lang["PATIENT_TREATMENTS"] = 'Treatments';

$lang["PATIENT_TREATMENT_NEW"] = 'New Treatment';
$lang["PATIENT_TREATMENT_ACTION_NEW"] = 'create new Treatment';
$lang["PATIENT_TREATMENT_TASK_NEW"] = 'new Session';

$lang["PATIENT_TREATMENT_STATUS_PLANNED"] = 'in Diagnosis';
$lang["PATIENT_TREATMENT_STATUS_PLANNED_TIME"] = '';
$lang["PATIENT_TREATMENT_STATUS_INPROGRESS"] = 'in Treatment';
$lang["PATIENT_TREATMENT_STATUS_INPROGRESS_TIME"] = '';
$lang["PATIENT_TREATMENT_STATUS_FINISHED"] = 'completed';
$lang["PATIENT_TREATMENT_STATUS_FINISHED_TIME"] = '';
$lang["PATIENT_TREATMENT_STATUS_STOPPED"] = 'cancelled';
$lang["PATIENT_TREATMENT_STATUS_STOPPED_TIME"] = '';

$lang["PATIENT_TREATMENT_DURATION"] = 'Treatment duration';
$lang["PATIENT_TREATMENT_DATE"] = 'Date of treatment';
$lang["PATIENT_TREATMENT_DOCTOR"] = 'Doctor';
$lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"] = 'Doctor diagnosis';
$lang["PATIENT_TREATMENT_DESCRIPTION"] = 'Description';
$lang["PATIENT_TREATMENT_PROTOCOL2"] = 'Prescription';

$lang["PATIENT_TREATMENT_DIAGNOSE"] = 'Diagnosis';
$lang["PATIENT_TREATMENT_DIAGNOSES"] = 'Diagnosis';
$lang["PATIENT_TREATMENT_PLAN"] = 'Treatment Plan';

$lang["PATIENT_TREATMENT_GOALS"] = 'Sessions';
$lang["PATIENT_TREATMENT_TASKS_TYPE"] = 'Treatment Type';
$lang["PATIENT_TREATMENT_TASKS_THERAPIST"] = 'Therapist';
$lang["PATIENT_TREATMENT_TASKS_PLACE"] = 'Location';
$lang["PATIENT_TREATMENT_TASKS_PLACE2"] = 'Ort';
$lang["PATIENT_TREATMENT_TASKS_DATE"] = 'Date';
$lang["PATIENT_TREATMENT_TASKS_TIME"] = 'Time';
$lang["PATIENT_TREATMENT_TASKS_DURATION"] = 'Duration';

$lang["PATIENT_TREATMENT_HELP"] = 'manual_patienten_behandlungen.pdf';

$lang["PATIENT_PRINT_TREATMENT"] = 'treatment.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/treatments/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>