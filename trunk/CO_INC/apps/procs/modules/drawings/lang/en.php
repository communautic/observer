<?php
$procs_drawings_name = "Drawings";

$lang["PROC_DRAWING_TITLE"] = 'Drawing';
$lang["PROC_DRAWINGS"] = 'Drawings';

$lang["PROC_DRAWING_NEW"] = 'New Drawing';
$lang["PROC_DRAWING_ACTION_NEW"] = 'create new Drawing';
$lang["PROC_DRAWING_TASK_NEW"] = 'new Session';

$lang["PROC_DRAWING_STATUS_PLANNED"] = 'in Diagnosis';
$lang["PROC_DRAWING_STATUS_PLANNED_TIME"] = '';
$lang["PROC_DRAWING_STATUS_INPROGRESS"] = 'in Drawing';
$lang["PROC_DRAWING_STATUS_INPROGRESS_TIME"] = '';
$lang["PROC_DRAWING_STATUS_FINISHED"] = 'completed';
$lang["PROC_DRAWING_STATUS_FINISHED_TIME"] = '';
$lang["PROC_DRAWING_STATUS_STOPPED"] = 'cancelled';
$lang["PROC_DRAWING_STATUS_STOPPED_TIME"] = '';

$lang["PROC_DRAWING_DURATION"] = 'Drawing duration';
$lang["PROC_DRAWING_DATE"] = 'Date of drawing';
$lang["PROC_DRAWING_DOCTOR"] = 'Doctor';
$lang["PROC_DRAWING_DOCTOR_DIAGNOSE"] = 'Doctor diagnosis';
$lang["PROC_DRAWING_DESCRIPTION"] = 'Description';
$lang["PROC_DRAWING_PROTOCOL2"] = 'Prescription';

$lang["PROC_DRAWING_DIAGNOSE"] = 'Diagnosis';
$lang["PROC_DRAWING_DIAGNOSES"] = 'Diagnosis';
$lang["PROC_DRAWING_PLAN"] = 'Drawing Plan';

$lang["PROC_DRAWING_GOALS"] = 'Sessions';
$lang["PROC_DRAWING_TASKS_TYPE"] = 'Drawing Type';
$lang["PROC_DRAWING_TASKS_THERAPIST"] = 'Therapist';
$lang["PROC_DRAWING_TASKS_PLACE"] = 'Location';
$lang["PROC_DRAWING_TASKS_PLACE2"] = 'Ort';
$lang["PROC_DRAWING_TASKS_DATE"] = 'Date';
$lang["PROC_DRAWING_TASKS_TIME"] = 'Time';
$lang["PROC_DRAWING_TASKS_DURATION"] = 'Duration';

$lang["PROC_DRAWING_HELP"] = 'manual_procen_behandlungen.pdf';

$lang["PROC_PRINT_DRAWING"] = 'drawing.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/drawings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>