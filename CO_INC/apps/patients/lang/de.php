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
$lang["PATIENT_FOLDER_TAB_LIST"] = 'Patientenliste';
$lang["PATIENT_FOLDER_TAB_INVOICES"] = 'Rechnungsarchiv';
$lang["PATIENT_FOLDER_TAB_INVOICES_DATE"] = 'Datum';
$lang["PATIENT_FOLDER_TAB_INVOICES_PATIENT"] = 'Patient';
$lang["PATIENT_FOLDER_TAB_INVOICES_NUMBER"] = 'Nummer';
$lang["PATIENT_FOLDER_TAB_INVOICES_STATUS"] = 'Status';
$lang["PATIENT_FOLDER_TAB_REVENUE"] = 'Umsatzberechnung';
$lang["PATIENT_FOLDER_TAB_BELEGE"] = 'Belegarchiv';
$lang["PATIENT_FOLDER_TAB_FILTER"] = 'Datenfilter';
$lang["PATIENT_FOLDER_TAB_THERAPIST"] = 'Betreuer';
$lang["PATIENT_FOLDER_TAB_CALCULATE"] = 'berechnen';
$lang["PATIENT_FOLDER_TAB_INVOICES"] = 'Rechnungen';
$lang["PATIENT_FOLDER_TAB_REVENUE"] = 'Umsatzergebnis';

$lang["PATIENT_TITLE"] = 'Patient';

$lang["PATIENT_STATUS_PLANNED"] = 'Warteliste';
$lang["PATIENT_STATUS_PLANNED_TIME"] = 'seit';
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
$lang["PATIENT_INSURANCE_NUMBER"] = 'Patient/in VSNR';
$lang["PATIENT_INSURER"] = 'Versicherte/r';
$lang["PATIENT_INSURANCE_INSURER_NUMBER"] = 'Versicherte/r VSNR';

$lang["PATIENT_INSURANCE_ADDITIONAL"] = 'Zusatzversicherung';
$lang["PATIENT_DESCRIPTION"] = 'Notiz';
$lang["PATIENT_CODE"] = 'Patientencode';
$lang["PATIENT_CODE_PO"] = 'Refnr.';
$lang["PATIENT_CODE_TO"] = 'Patientencode';
$lang["PATIENT_DOB"] = 'Geburtsdatum';
$lang["PATIENT_COO"] = 'Beruf';
$lang["PATIENT_FAMILYSTATUS"] = 'Familienstand';


$lang["PATIENT_HANDBOOK"] = 'Patientenakt';

$lang["PATIENT_HELP"] = 'manual_patienten_patienten.pdf';
$lang["PATIENT_FOLDER_HELP"] = 'manual_patienten_ordner.pdf';

// Print images
$lang["PRINT_PATIENT_MANUAL"] = 'patientenakt.png';
$lang["PRINT_PATIENT"] = 'patient.png';
$lang["PRINT_PATIENT_FOLDER"] = 'patientenliste.png';
$lang["PRINT_PATIENT_RECHNUNGEN"] = 'rechnungen.png';
$lang["PRINT_PATIENT_UMSATZ"] = 'umsatzergebnis.png';
$lang["PRINT_PATIENT_BELEGE"] = 'belegarchiv.png';

// Dektop Widget
$lang["PATIENT_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["PATIENT_WIDGET_TITLE"] 	=	'Mahnung';
$lang["PATIENT_WIDGET_ALERT"] 	= 	'Rechnung "%1$s" für den Patienten "%2$s" ist <span class="yellow">außer Plan</span>';
$lang["PATIENT_WIDGET_TITLE_INVOICE"] 	=	'Rechnung';
$lang["PATIENT_WIDGET_REMINDER_INVOICE"] 	= 	'Rechnung "%1$s" für den Patienten "%2$s" ist <span class="yellow">erstellt</span>';
$lang["PATIENT_WIDGET_TITLE_WAITINGLIST"] 	=	'Warteliste';
$lang["PATIENT_WIDGET_REMINDER_WAITINGLIST"] 	= 	'Patient "%1$s" ist noch auf der <span class="yellow">Warteliste</span> für eine Behandlung';

$lang["EVENTTYPE"][1] = 'Sitzung';
$lang["EVENTTYPE"][2] = 'Neuaufnahme';
$lang["EVENTTYPE"][3] = 'Patient';
$lang["EVENTTYPE"][4] = 'Behandlung';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>