<?php
$patients_services_name = "Zusatzleistungen";

$lang["PATIENT_SERVICE_TITLE"] = 'Zusatzleistung';
$lang["PATIENT_SERVICES"] = 'Zusatzleistungen';

$lang["PATIENT_SERVICE_NEW"] = 'Neue Zusatzleistung';
$lang["PATIENT_SERVICE_ACTION_NEW"] = 'neue Zusatzleistung anlegen';
$lang["PATIENT_SERVICE_TASK_NEW"] = 'Inhalte';

$lang["PATIENT_SERVICE_AMOUNT"] = 'Gesamtkosten';
$lang["PATIENT_SERVICE_DISCOUNT"] = 'Rabattierung';
$lang["PATIENT_SERVICE_DISCOUNT_SHORT"] = 'Rabatt';
$lang["PATIENT_SERVICE_VAT"] = 'Mehrwertsteuer';
$lang["PATIENT_SERVICE_VAT_SHORT"] = 'Mwst';

$lang["PATIENT_SERVICE_GOALS"] = 'Themen';


$lang["PATIENT_SERVICE_POSPONED"] = 'verschoben';

$lang["PATIENT_SERVICE_HELP"] = 'manual_patienten_service.pdf';

$lang["PATIENT_PRINT_SERVICE"] = 'zusatzleistung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/services/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>