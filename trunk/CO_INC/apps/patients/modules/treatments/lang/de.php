<?php
$patients_treatments_name = "Behandlungen";

$lang["PATIENT_TREATMENT_TITLE"] = 'Behandlung';
$lang["PATIENT_TREATMENTS"] = 'Behandlungen';

$lang["PATIENT_TREATMENT_NEW"] = 'Neue Behandlung';
$lang["PATIENT_TREATMENT_ACTION_NEW"] = 'neue Behandlung anlegen';
$lang["PATIENT_TREATMENT_TASK_NEW"] = 'Neues Einzelziel';
//define('TREATMENT_RELATES_TO', 'bezogen auf');
$lang["PATIENT_TREATMENT_DATE"] = 'Datum';
$lang["PATIENT_TREATMENT_PLACE"] = 'Ort';
$lang["PATIENT_TREATMENT_TIME_START"] = 'Start';
$lang["PATIENT_TREATMENT_TIME_END"] = 'Ende';

$lang["PATIENT_TREATMENT_ATTENDEES"] = 'Teilnehmer';
$lang["PATIENT_TREATMENT_MANAGEMENT"] = 'Protokollführer';

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