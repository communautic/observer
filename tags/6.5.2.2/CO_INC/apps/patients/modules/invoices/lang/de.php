<?php
$patients_invoices_name = "Rechnungen";

$lang["PATIENT_INVOICE_TITLE"] = 'Rechnung';
$lang["PATIENT_INVOICE_TITLE_STATISTICS"] = 'Gesamtstatistik';
$lang["PATIENT_INVOICES"] = 'Rechnungen';

$lang["PATIENT_INVOICE_NEW"] = 'Neue Rechnung';
$lang["PATIENT_INVOICE_ACTION_NEW"] = 'neue Rechnung anlegen';
//$lang["PATIENT_INVOICE_TASK_NEW"] = 'Neues Einzelziel';
//define('INVOICE_RELATES_TO', 'bezogen auf');
$lang["PATIENT_INVOICE_DATE"] = 'Rechnungsdatum';
$lang["PATIENT_INVOICE_DATE_SENT"] = 'Rechnungsversand';
$lang["PATIENT_INVOICE_NUMBER"] = 'Rechnungsnummer';
$lang["PATIENT_INVOICE_PAYMENT_REMINDER"] = 'Mahnung';
$lang["PATIENT_INVOICE_SERVICES"] = 'Leistungen';
$lang["PATIENT_INVOICE_SERVICES_LIST"] = 'Leistungsaufstellung';
$lang["PATIENT_INVOICE_SERVICES_FOR"] = 'für';
$lang["PATIENT_INVOICE_SERVICES_INVOICENO"] = 'zu Rechnungsnummer';

$lang["PATIENT_INVOICE_TEXT_CITATION"] = 'Sehr geehrte/r';
$lang["PATIENT_INVOICE_TEXT_LINE1"] = 'Für die von uns erbrachten Leistungen erlaube ich mir nachstehende Honorarnote zu legen:';
$lang["PATIENT_INVOICE_TEXT_LINE2"] = 'Ich danke für Ihr Vertrauen und bitte um Anweisung des Gesamthonorars innerhalb von 10 Tagen.';
$lang["PATIENT_INVOICE_TEXT_LINE3"] = 'Wenn die Möglichkeit einer tarifgemäßen Rückerstattung von Kosten besteht, dann übermitteln Sie Ihrer Versicherung diese Honorarnote im Original sowie Ihren Überweisungsschein und Einzahlungsbeleg.';
$lang["PATIENT_INVOICE_TEXT_LINE4"] = 'Mit freundlichen Grüßen,';


/*$lang["PATIENT_INVOICE_PLACE"] = 'Ort';
$lang["PATIENT_INVOICE_TIME_START"] = 'Start';
$lang["PATIENT_INVOICE_TIME_END"] = 'Ende';

$lang["PATIENT_INVOICE_ATTENDEES"] = 'Teilnehmer';
$lang["PATIENT_INVOICE_MANAGEMENT"] = 'Protokollführer';
$lang["PATIENT_INVOICE_DESCRIPTION"] = 'Beschreibung';*/

$lang["PATIENT_INVOICE_STATUS_PLANNED"] = 'erstellt';
$lang["PATIENT_INVOICE_STATUS_PLANNED_TIME"] = 'am';
$lang["PATIENT_INVOICE_STATUS_INPROGRESS"] = 'ausständig';
$lang["PATIENT_INVOICE_STATUS_INPROGRESS_TIME"] = 'seit';
$lang["PATIENT_INVOICE_STATUS_FINISHED"] = 'bezahlt';
$lang["PATIENT_INVOICE_STATUS_FINISHED_TIME"] = 'am';

$lang["PATIENT_INVOICE_DURATION"] = 'Behandlungsdauer';
$lang["PATIENT_INVOICE_LIST"] = 'Auflistung';
$lang["PATIENT_INVOICE_TOTALS"] = 'Gesamthonorar';

$lang["PATIENT_INVOICE_NOTES"] = 'Notiz';

//$lang["PATIENT_INVOICE_GOALS"] = 'Einzelziele';
//$lang["PATIENT_INVOICE_TASKS_START"] = 'Start';
//$lang["PATIENT_INVOICE_TASKS_END"] = 'Ende';

//$lang["PATIENT_INVOICE_POSPONED"] = 'verschoben';

$lang["PATIENT_INVOICE_PRINTOPTION_INVOICE"] = 'Rechnung';
$lang["PATIENT_INVOICE_PRINTOPTION_SERVICES"] = 'Leistungen';
$lang["PATIENT_INVOICE_PRINTOPTION_PAYMENT_REMINDER"] = 'Mahnung';
$lang["PATIENT_INVOICE_PRINTOPTION_ENVELOPE"] = 'Kuvert';

$lang["PATIENT_INVOICE_HELP"] = 'manual_patienten_rechnungen.pdf';

$lang["PATIENT_PRINT_INVOICE"] = 'rechnung.png';
$lang["PATIENT_PRINT_SERVICES"] = 'leistungen.png';
$lang["PATIENT_PRINT_REMINDER"] = 'mahnung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/invoices/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>