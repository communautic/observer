<?php
$patients_treatments_name = "Behandlungen";

$lang["PATIENT_TREATMENT_TITLE"] = 'Behandlung';
$lang["PATIENT_TREATMENTS"] = 'Behandlungen';

$lang["PATIENT_TREATMENT_NEW"] = 'Neue Behandlung';
$lang["PATIENT_TREATMENT_ACTION_NEW"] = 'neue Behandlung anlegen';
$lang["PATIENT_TREATMENT_TASK_NEW"] = 'Neues Einzelziel';
//define('TREATMENT_RELATES_TO', 'bezogen auf');

$lang["PATIENT_TREATMENT_STATUS_PLANNED"] = 'in Befundung';
$lang["PATIENT_TREATMENT_STATUS_PLANNED_TIME"] = 'seit';
$lang["PATIENT_TREATMENT_STATUS_INPROGRESS"] = 'in Befundung';
$lang["PATIENT_TREATMENT_STATUS_INPROGRESS_TIME"] = 'seit';
$lang["PATIENT_TREATMENT_STATUS_FINISHED"] = 'abgeschlossen';
$lang["PATIENT_TREATMENT_STATUS_FINISHED_TIME"] = 'am';
$lang["PATIENT_TREATMENT_STATUS_STOPPED"] = 'abgebrochen';
$lang["PATIENT_TREATMENT_STATUS_STOPPED_TIME"] = 'am';

$lang["PATIENT_TREATMENT_DATE"] = 'Befundungsdatum';
$lang["PATIENT_TREATMENT_DOCTOR"] = 'Arzt';
$lang["PATIENT_TREATMENT_DOCTOR_DIAGNOSE"] = 'Arztdiagnose';
$lang["PATIENT_TREATMENT_PROTOCOL2"] = 'Verordnung';

$lang["PATIENT_TREATMENT_GOALS"] = 'Sitzungen';
$lang["PATIENT_TREATMENT_TASKS_START"] = 'Start';
$lang["PATIENT_TREATMENT_TASKS_END"] = 'Ende';

$lang["PATIENT_TREATMENT_POSPONED"] = 'verschoben';

$lang["PATIENT_TREATMENT_HELP"] = 'manual_mitarbeiter_zielvereinbarungen.pdf';

$lang["PATIENT_PRINT_TREATMENT"] = 'zielvereinbarung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/treatments/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>