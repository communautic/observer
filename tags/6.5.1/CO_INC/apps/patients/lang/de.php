<?php
// App name
$patients_name = "Patienten";
$lang["patients_name"] = 'Patienten';

// Left
$lang["PATIENT_FOLDER"] = 'Ordner';
$lang["PATIENT_FOLDER_NEW"] = 'Neuer Ordner';
$lang["PATIENT_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["PATIENT_PATIENTS"] = 'Patienten';
$lang["PATIENT_NEW"] = 'Neuer Patient';
$lang["PATIENT_ACTION_NEW"] = 'neuen Patienten anlegen';

// Patient Right
$lang["PATIENT_TITLE"] = 'Patient';

$lang["PATIENT_STATUS_PLANNED"] = 'erfasst';
$lang["PATIENT_STATUS_PLANNED_TIME"] = 'am';
$lang["PATIENT_STATUS_FINISHED"] = 'in Betreuung';
$lang["PATIENT_STATUS_FINISHED_TIME"] = 'seit';
$lang["PATIENT_STATUS_STOPPED"] = 'in Evidenz';
$lang["PATIENT_STATUS_STOPPED_TIME"] = 'seit';

$lang["PATIENT_MANAGEMENT"] = 'Betreuung';
$lang["PATIENT_CONTACT_DETAILS"] = 'Kontaktdaten';

$lang["PATIENT_CONTACT_POSITION"] = 'Position';
$lang["PATIENT_CONTACT_PHONE"] = 'Telefon';
$lang["PATIENT_CONTACT_EMAIL"] = 'E-mail';
$lang["PATIENT_INSURANCE"] = 'Versicherung';
$lang["PATIENT_INSURANCE_NUMBER"] = 'Versicherungsnummer';
$lang["PATIENT_INSURANCE_ADDITIONAL"] = 'Zusatzversicherung';
$lang["PATIENT_DESCRIPTION"] = 'Historie';
$lang["PATIENT_DOB"] = 'Geburtsdatum';
$lang["PATIENT_COO"] = 'Nationalität';

$lang["PATIENT_HANDBOOK"] = 'Patientenakt';

$lang["PATIENT_HELP"] = 'manual_patienten_patienten.pdf';
$lang["PATIENT_FOLDER_HELP"] = 'manual_patienten_ordner.pdf';

// Print images
$lang["PRINT_PATIENT_MANUAL"] = 'patientenakt.png';
$lang["PRINT_PATIENT"] = 'patient.png';
$lang["PRINT_PATIENT_FOLDER"] = 'ordner.png';

// Dektop Widget
$lang["PATIENT_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["PATIENT_WIDGET_TITLE"] 	=	'Mahnung';
$lang["PATIENT_WIDGET_ALERT"] 	= 	'Rechnung "%1$s" für den Patienten "%2$s" ist <span class="yellow">außer Plan</span>';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>