<?php
$patients_treatments_name = "Treatments";

$lang["PATIENT_TREATMENT_TITLE"] = 'Treatment';
$lang["PATIENT_TREATMENTS"] = 'Treatments';

$lang["PATIENT_TREATMENT_NEW"] = 'New Treatment';
$lang["PATIENT_TREATMENT_ACTION_NEW"] = 'new Treatment';
$lang["PATIENT_TREATMENT_TASK_NEW"] = 'New Item';
//define('TREATMENT_RELATES_TO', 'bezogen auf');
$lang["PATIENT_TREATMENT_DATE"] = 'Date';
$lang["PATIENT_TREATMENT_PLACE"] = 'Location';
$lang["PATIENT_TREATMENT_TIME_START"] = 'Start';
$lang["PATIENT_TREATMENT_TIME_END"] = 'End';

$lang["PATIENT_TREATMENT_ATTENDEES"] = 'Attendees';
$lang["PATIENT_TREATMENT_MANAGEMENT"] = 'Minuted by';
$lang["PATIENT_TREATMENT_GOALS"] = 'Agenda';

$lang["PATIENT_TREATMENT_POSPONED"] = 'posponed';


$lang["PATIENT_TREATMENT_HELP"] = 'manual_mitarbeiter_zielvereinbarungen.pdf';

$lang["PATIENT_PRINT_TREATMENT"] = 'treatment.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/treatments/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>