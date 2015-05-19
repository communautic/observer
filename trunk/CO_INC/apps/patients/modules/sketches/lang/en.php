<?php
$patients_sketches_name = "Sketches";

$lang["PATIENT_SKETCH_TITLE"] = 'Sketch';
$lang["PATIENT_SKETCHES"] = 'Sketches';

$lang["PATIENT_SKETCH_NEW"] = 'New Sketch';
$lang["PATIENT_SKETCH_ACTION_NEW"] = 'create new Sketch';
$lang["PATIENT_SKETCH_TASK_NEW"] = 'new Session';

$lang["PATIENT_SKETCH_STATUS_PLANNED"] = 'in diagnosis';
$lang["PATIENT_SKETCH_STATUS_PLANNED_TIME"] = '';
$lang["PATIENT_SKETCH_STATUS_INPROGRESS"] = 'in sketch';
$lang["PATIENT_SKETCH_STATUS_INPROGRESS_TIME"] = '';
$lang["PATIENT_SKETCH_STATUS_FINISHED"] = 'completed';
$lang["PATIENT_SKETCH_STATUS_FINISHED_TIME"] = '';
$lang["PATIENT_SKETCH_STATUS_STOPPED"] = 'cancelled';
$lang["PATIENT_SKETCH_STATUS_STOPPED_TIME"] = '';

$lang["PATIENT_SKETCH_DURATION"] = 'Sketch duration';
$lang["PATIENT_SKETCH_DATE"] = 'Date of diagnosis';
$lang["PATIENT_SKETCH_DOCTOR"] = 'Doctor';
$lang["PATIENT_SKETCH_DOCTOR_DIAGNOSE"] = 'Medical findings';
$lang["PATIENT_SKETCH_DESCRIPTION"] = 'Description';
$lang["PATIENT_SKETCH_PROTOCOL2"] = 'Prescription';

$lang["PATIENT_SKETCH_AMOUNT"] = 'Amount';
$lang["PATIENT_SKETCH_DISCOUNT"] = 'Discount';
$lang["PATIENT_SKETCH_DISCOUNT_SHORT"] = 'Discount';
$lang["PATIENT_SKETCH_VAT"] = 'VAT';
$lang["PATIENT_SKETCH_VAT_SHORT"] = 'VAT';

$lang["PATIENT_SKETCH_DIAGNOSE"] = 'Diagnosis';
$lang["PATIENT_SKETCH_DIAGNOSES"] = 'Diagnosis';
$lang["PATIENT_SKETCH_PLAN"] = 'Sketch Plan';

$lang["PATIENT_SKETCH_GOALS"] = 'Sessions';
$lang["PATIENT_SKETCH_GOALS_SINGUAL"] = 'Session';
$lang["PATIENT_SKETCH_TASKS_TYPE"] = 'Sketch Type';
$lang["PATIENT_SKETCH_TASKS_THERAPIST"] = 'Therapist';
$lang["PATIENT_SKETCH_TASKS_PLACE"] = 'Location';
$lang["PATIENT_SKETCH_TASKS_PLACE2"] = 'Ort';
$lang["PATIENT_SKETCH_TASKS_DATE"] = 'Date';
$lang["PATIENT_SKETCH_TASKS_DATE_CALENDAR"] = 'Calendar date';
$lang["PATIENT_SKETCH_TASKS_TIME"] = 'Time';
$lang["PATIENT_SKETCH_TASKS_DATE_INVOICE"] = 'Date of invoice';
$lang["PATIENT_SKETCH_TASKS_DURATION"] = 'Duration';

$lang["PATIENT_SKETCH_HELP"] = 'manual_patients_sketches.pdf';

$lang["PATIENT_PRINT_SKETCH"] = 'sketch.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/sketches/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>