<?php
$projects_sketches_name = "Visualisierungen";

$lang["PROJECT_SKETCH_TITLE"] = 'Visualisierung';
$lang["PROJECT_SKETCHES"] = 'Visualisierungen';

$lang["PROJECT_SKETCH_NEW"] = 'Neue Visualisierung';
$lang["PROJECT_SKETCH_ACTION_NEW"] = 'neue Visualisierung anlegen';
$lang["PROJECT_SKETCH_TASK_NEW"] = 'Neue Visualisierung';

$lang["PROJECT_SKETCH_STATUS_PLANNED"] = 'in Befundung';
$lang["PROJECT_SKETCH_STATUS_PLANNED_TIME"] = 'seit';
$lang["PROJECT_SKETCH_STATUS_INPROGRESS"] = 'in Behandlung';
$lang["PROJECT_SKETCH_STATUS_INPROGRESS_TIME"] = 'seit';
$lang["PROJECT_SKETCH_STATUS_FINISHED"] = 'abgeschlossen';
$lang["PROJECT_SKETCH_STATUS_FINISHED_TIME"] = 'am';
$lang["PROJECT_SKETCH_STATUS_STOPPED"] = 'abgebrochen';
$lang["PROJECT_SKETCH_STATUS_STOPPED_TIME"] = 'am';

$lang["PROJECT_SKETCH_DURATION"] = 'Behandlungsdauer';
$lang["PROJECT_SKETCH_DATE"] = 'Befundungsdatum';
$lang["PROJECT_SKETCH_DOCTOR"] = 'Arzt';
$lang["PROJECT_SKETCH_DOCTOR_DIAGNOSE"] = 'Arztdiagnose';
$lang["PROJECT_SKETCH_DESCRIPTION"] = 'Beschreibung';
$lang["PROJECT_SKETCH_PROTOCOL2"] = 'Verordnung';

$lang["PROJECT_SKETCH_AMOUNT"] = 'Kosten';
$lang["PROJECT_SKETCH_DISCOUNT"] = 'Rabattierung';
$lang["PROJECT_SKETCH_DISCOUNT_SHORT"] = 'Rabatt';
$lang["PROJECT_SKETCH_VAT"] = 'Mehrwertsteuer';
$lang["PROJECT_SKETCH_VAT_SHORT"] = 'Mwst';

$lang["PROJECT_SKETCH_DIAGNOSE"] = 'Befundung';
$lang["PROJECT_SKETCH_DIAGNOSES"] = 'Befundungen';
$lang["PROJECT_SKETCH_PLAN"] = 'Behandlungsplan';

$lang["PROJECT_SKETCH_GOALS"] = 'Sitzungen';
$lang["PROJECT_SKETCH_GOALS_SINGUAL"] = 'Sitzung';
$lang["PROJECT_SKETCH_TASKS_TYPE"] = 'Behandlungsart';
$lang["PROJECT_SKETCH_TASKS_THERAPIST"] = 'Therapeut';
$lang["PROJECT_SKETCH_TASKS_PLACE"] = 'Behandlungsort';
$lang["PROJECT_SKETCH_TASKS_PLACE2"] = 'Ort';
$lang["PROJECT_SKETCH_TASKS_DATE"] = 'Datum';
$lang["PROJECT_SKETCH_TASKS_DATE_CALENDAR"] = 'Kalenderdatum';
$lang["PROJECT_SKETCH_TASKS_TIME"] = 'Uhrzeit';
$lang["PROJECT_SKETCH_TASKS_DATE_INVOICE"] = 'Verrechnungsdatum';
$lang["PROJECT_SKETCH_TASKS_DURATION"] = 'Dauer';

$lang["PROJECT_SKETCH_ACTION_NEW"] = 'neu';
$lang["PROJECT_SKETCH_ACTION_NEW_CUSTOM"] = 'Bodychart';
$lang["PROJECT_SKETCH_ACTION_DRAW"] = 'zeichnen';
$lang["PROJECT_SKETCH_ACTION_DELETE"] = 'l&ouml;schen';
$lang["PROJECT_SKETCH_ACTION_ROTATE"] = 'Grafik drehen';
$lang["PROJECT_SKETCH_ACTION_CLEAR"] = 'Inhalt entfernen';
$lang["PROJECT_SKETCH_ACTION_UNDO"] = 'r&uuml;ckg&auml;ngig';

if(CO_PRODUCT_VARIANT == 2) {
	$lang["PROJECT_SKETCH_HELP"] = 'manual_projecten_visualisierung_to.pdf';
} else {
	$lang["PROJECT_SKETCH_HELP"] = 'manual_projecten_visualisierungen.pdf';
}

$lang["PROJECT_PRINT_SKETCH"] = 'visualisierung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/sketches/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>