<?php
$procs_drawings_name = "Skizzen";

$lang["PROC_DRAWING_TITLE"] = 'Skizze';
$lang["PROC_DRAWINGS"] = 'Skizzen';

$lang["PROC_DRAWING_NEW"] = 'Neue Skizze';
$lang["PROC_DRAWING_ACTION_NEW"] = 'neue Skizze anlegen';
$lang["PROC_DRAWING_TASK_NEW"] = 'Neue Sitzung';

$lang["PROC_DRAWING_STATUS_PLANNED"] = 'in Befundung';
$lang["PROC_DRAWING_STATUS_PLANNED_TIME"] = 'seit';
$lang["PROC_DRAWING_STATUS_INPROGRESS"] = 'in Behandlung';
$lang["PROC_DRAWING_STATUS_INPROGRESS_TIME"] = 'seit';
$lang["PROC_DRAWING_STATUS_FINISHED"] = 'abgeschlossen';
$lang["PROC_DRAWING_STATUS_FINISHED_TIME"] = 'am';
$lang["PROC_DRAWING_STATUS_STOPPED"] = 'abgebrochen';
$lang["PROC_DRAWING_STATUS_STOPPED_TIME"] = 'am';

$lang["PROC_DRAWING_DURATION"] = 'Behandlungsdauer';
$lang["PROC_DRAWING_DATE"] = 'Befundungsdatum';
$lang["PROC_DRAWING_DOCTOR"] = 'Arzt';
$lang["PROC_DRAWING_DOCTOR_DIAGNOSE"] = 'Arztdiagnose';
$lang["PROC_DRAWING_DESCRIPTION"] = 'Beschreibung';
$lang["PROC_DRAWING_PROTOCOL2"] = 'Verordnung';

$lang["PROC_DRAWING_DIAGNOSE"] = 'Befundung';
$lang["PROC_DRAWING_DIAGNOSES"] = 'Befundungen';
$lang["PROC_DRAWING_PLAN"] = 'Behandlungsplan';

$lang["PROC_DRAWING_HELP"] = 'manual_procen_behandlungen.pdf';

$lang["PROC_PRINT_DRAWING"] = 'behandlung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/drawings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>