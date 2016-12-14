<?php
$patients_services_name = "Services";

$lang["PATIENT_SERVICE_TITLE"] = 'Service';
$lang["PATIENT_SERVICES"] = 'Services';

$lang["PATIENT_SERVICE_NEW"] = 'New Service';
$lang["PATIENT_SERVICE_ACTION_NEW"] = 'new Service';
$lang["PATIENT_SERVICE_TASK_NEW"] = 'New Item';
//define('SERVICE_RELATES_TO', 'bezogen auf');
$lang["PATIENT_SERVICE_DATE"] = 'Date';
$lang["PATIENT_SERVICE_PLACE"] = 'Location';
$lang["PATIENT_SERVICE_TIME_START"] = 'Start';
$lang["PATIENT_SERVICE_TIME_END"] = 'End';

$lang["PATIENT_SERVICE_ATTENDEES"] = 'Attendees';
$lang["PATIENT_SERVICE_MANAGEMENT"] = 'Minuted by';
$lang["PATIENT_SERVICE_GOALS"] = 'Agenda';
$lang["PATIENT_SERVICE_COPY"] = 'Copy';

$lang["PATIENT_SERVICE_POSPONED"] = 'posponed';


$lang["PATIENT_SERVICE_HELP"] = 'manual_patients_services.pdf';

$lang["PATIENT_PRINT_SERVICE"] = 'service.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/services/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>