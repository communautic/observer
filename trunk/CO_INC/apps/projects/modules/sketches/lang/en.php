<?php
$projects_sketches_name = "Sketches";

$lang["PROJECT_SKETCH_TITLE"] = 'Sketch';
$lang["PROJECT_SKETCHES"] = 'Sketches';

$lang["PROJECT_SKETCH_NEW"] = 'New Sketch';
$lang["PROJECT_SKETCH_ACTION_NEW_CUSTOM"] = 'Bodychart';
$lang["PROJECT_SKETCH_ACTION_NEW"] = 'create new Sketch';
$lang["PROJECT_SKETCH_TASK_NEW"] = 'new Session';

$lang["PROJECT_SKETCH_STATUS_PLANNED"] = 'in diagnosis';
$lang["PROJECT_SKETCH_STATUS_PLANNED_TIME"] = '';
$lang["PROJECT_SKETCH_STATUS_INPROGRESS"] = 'in sketch';
$lang["PROJECT_SKETCH_STATUS_INPROGRESS_TIME"] = '';
$lang["PROJECT_SKETCH_STATUS_FINISHED"] = 'completed';
$lang["PROJECT_SKETCH_STATUS_FINISHED_TIME"] = '';
$lang["PROJECT_SKETCH_STATUS_STOPPED"] = 'cancelled';
$lang["PROJECT_SKETCH_STATUS_STOPPED_TIME"] = '';

$lang["PROJECT_SKETCH_DURATION"] = 'Sketch duration';
$lang["PROJECT_SKETCH_DATE"] = 'Date of diagnosis';
$lang["PROJECT_SKETCH_DOCTOR"] = 'Doctor';
$lang["PROJECT_SKETCH_DOCTOR_DIAGNOSE"] = 'Medical findings';
$lang["PROJECT_SKETCH_DESCRIPTION"] = 'Description';
$lang["PROJECT_SKETCH_PROTOCOL2"] = 'Prescription';

$lang["PROJECT_SKETCH_AMOUNT"] = 'Amount';
$lang["PROJECT_SKETCH_DISCOUNT"] = 'Discount';
$lang["PROJECT_SKETCH_DISCOUNT_SHORT"] = 'Discount';
$lang["PROJECT_SKETCH_VAT"] = 'VAT';
$lang["PROJECT_SKETCH_VAT_SHORT"] = 'VAT';

$lang["PROJECT_SKETCH_DIAGNOSE"] = 'Diagnosis';
$lang["PROJECT_SKETCH_DIAGNOSES"] = 'Diagnosis';
$lang["PROJECT_SKETCH_PLAN"] = 'Sketch Plan';

$lang["PROJECT_SKETCH_GOALS"] = 'Sessions';
$lang["PROJECT_SKETCH_GOALS_SINGUAL"] = 'Session';
$lang["PROJECT_SKETCH_TASKS_TYPE"] = 'Sketch Type';
$lang["PROJECT_SKETCH_TASKS_THERAPIST"] = 'Therapist';
$lang["PROJECT_SKETCH_TASKS_PLACE"] = 'Location';
$lang["PROJECT_SKETCH_TASKS_PLACE2"] = 'Ort';
$lang["PROJECT_SKETCH_TASKS_DATE"] = 'Date';
$lang["PROJECT_SKETCH_TASKS_DATE_CALENDAR"] = 'Calendar date';
$lang["PROJECT_SKETCH_TASKS_TIME"] = 'Time';
$lang["PROJECT_SKETCH_TASKS_DATE_INVOICE"] = 'Date of invoice';
$lang["PROJECT_SKETCH_TASKS_DURATION"] = 'Duration';

$lang["PROJECT_SKETCH_HELP"] = 'manual_projects_sketches.pdf';

$lang["PROJECT_PRINT_SKETCH"] = 'sketch.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/sketches/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>