<?php
$patients_sketches_name = "Visualisierungen";

$lang["PATIENT_SKETCH_TITLE"] = 'Visualisierung';
$lang["PATIENT_SKETCHES"] = 'Visualisierungen';

$lang["PATIENT_SKETCH_NEW"] = 'Neue Visualisierung';
$lang["PATIENT_SKETCH_ACTION_NEW"] = 'neue Visualisierung anlegen';
$lang["PATIENT_SKETCH_TASK_NEW"] = 'Neue Visualisierung';

$lang["PATIENT_SKETCH_STATUS_PLANNED"] = 'in Befundung';
$lang["PATIENT_SKETCH_STATUS_PLANNED_TIME"] = 'seit';
$lang["PATIENT_SKETCH_STATUS_INPROGRESS"] = 'in Behandlung';
$lang["PATIENT_SKETCH_STATUS_INPROGRESS_TIME"] = 'seit';
$lang["PATIENT_SKETCH_STATUS_FINISHED"] = 'abgeschlossen';
$lang["PATIENT_SKETCH_STATUS_FINISHED_TIME"] = 'am';
$lang["PATIENT_SKETCH_STATUS_STOPPED"] = 'abgebrochen';
$lang["PATIENT_SKETCH_STATUS_STOPPED_TIME"] = 'am';

$lang["PATIENT_SKETCH_DURATION"] = 'Behandlungsdauer';
$lang["PATIENT_SKETCH_DATE"] = 'Befundungsdatum';
$lang["PATIENT_SKETCH_DOCTOR"] = 'Arzt';
$lang["PATIENT_SKETCH_DOCTOR_DIAGNOSE"] = 'Arztdiagnose';
$lang["PATIENT_SKETCH_DESCRIPTION"] = 'Beschreibung';
$lang["PATIENT_SKETCH_PROTOCOL2"] = 'Verordnung';

$lang["PATIENT_SKETCH_AMOUNT"] = 'Kosten';
$lang["PATIENT_SKETCH_DISCOUNT"] = 'Rabattierung';
$lang["PATIENT_SKETCH_DISCOUNT_SHORT"] = 'Rabatt';
$lang["PATIENT_SKETCH_VAT"] = 'Mehrwertsteuer';
$lang["PATIENT_SKETCH_VAT_SHORT"] = 'Mwst';

$lang["PATIENT_SKETCH_DIAGNOSE"] = 'Befundung';
$lang["PATIENT_SKETCH_DIAGNOSES"] = 'Befundungen';
$lang["PATIENT_SKETCH_PLAN"] = 'Behandlungsplan';

$lang["PATIENT_SKETCH_GOALS"] = 'Sitzungen';
$lang["PATIENT_SKETCH_GOALS_SINGUAL"] = 'Sitzung';
$lang["PATIENT_SKETCH_TASKS_TYPE"] = 'Behandlungsart';
$lang["PATIENT_SKETCH_TASKS_THERAPIST"] = 'Therapeut';
$lang["PATIENT_SKETCH_TASKS_PLACE"] = 'Behandlungsort';
$lang["PATIENT_SKETCH_TASKS_PLACE2"] = 'Ort';
$lang["PATIENT_SKETCH_TASKS_DATE"] = 'Datum';
$lang["PATIENT_SKETCH_TASKS_DATE_CALENDAR"] = 'Kalenderdatum';
$lang["PATIENT_SKETCH_TASKS_TIME"] = 'Uhrzeit';
$lang["PATIENT_SKETCH_TASKS_DATE_INVOICE"] = 'Verrechnungsdatum';
$lang["PATIENT_SKETCH_TASKS_DURATION"] = 'Dauer';

$lang["PATIENT_SKETCH_ACTION_NEW"] = 'neu';
$lang["PATIENT_SKETCH_ACTION_NEW_CUSTOM"] = 'Bodychart';
$lang["PATIENT_SKETCH_ACTION_DRAW"] = 'zeichnen';
$lang["PATIENT_SKETCH_ACTION_DELETE"] = 'l&ouml;schen';
$lang["PATIENT_SKETCH_ACTION_ROTATE"] = 'Grafik drehen';
$lang["PATIENT_SKETCH_ACTION_CLEAR"] = 'Inhalt entfernen';
$lang["PATIENT_SKETCH_ACTION_UNDO"] = 'r&uuml;ckg&auml;ngig';


$lang["PATIENT_SKETCH_HELP"] = 'manual_patienten_visualisierungen.pdf';

$lang["PATIENT_PRINT_SKETCH"] = 'visualisierung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/sketches/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>