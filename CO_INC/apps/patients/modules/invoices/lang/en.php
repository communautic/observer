<?php
$patients_invoices_name = "Invoices";

$lang["PATIENT_INVOICE_TITLE"] = 'Rechnung';
$lang["PATIENT_INVOICE_TITLE_STATISTICS"] = 'Gesamtstatistik';
$lang["PATIENT_INVOICES"] = 'Rechnungen';

$lang["PATIENT_INVOICE_NEW"] = 'Neue Rechnung';
$lang["PATIENT_INVOICE_ACTION_NEW"] = 'neue Rechnung anlegen';
//$lang["PATIENT_INVOICE_TASK_NEW"] = 'Neues Einzelziel';
//define('INVOICE_RELATES_TO', 'bezogen auf');
$lang["PATIENT_INVOICE_DATE"] = 'Invoice date';
$lang["PATIENT_INVOICE_DATE_SENT"] = 'Invoice sent';
$lang["PATIENT_INVOICE_NUMBER"] = 'Invoice No.';
$lang["PATIENT_INVOICE_PAYMENT_REMINDER"] = 'Payment Reminder';

$lang["PATIENT_INVOICE_TEXT_CITATION"] = 'Dear';
$lang["PATIENT_INVOICE_TEXT_LINE1"] = 'Please see the following invoice for the provided services by us:';
$lang["PATIENT_INVOICE_TEXT_LINE2"] = 'Please make payment within the next 10 work days';
$lang["PATIENT_INVOICE_TEXT_LINE3"] = '';
$lang["PATIENT_INVOICE_TEXT_LINE4"] = 'Kind regards,';


/*$lang["PATIENT_INVOICE_PLACE"] = 'Ort';
$lang["PATIENT_INVOICE_TIME_START"] = 'Start';
$lang["PATIENT_INVOICE_TIME_END"] = 'Ende';

$lang["PATIENT_INVOICE_ATTENDEES"] = 'Teilnehmer';
$lang["PATIENT_INVOICE_MANAGEMENT"] = 'Protokollführer';
$lang["PATIENT_INVOICE_DESCRIPTION"] = 'Beschreibung';*/

$lang["PATIENT_INVOICE_STATUS_PLANNED"] = 'created';
$lang["PATIENT_INVOICE_STATUS_PLANNED_TIME"] = 'on';
$lang["PATIENT_INVOICE_STATUS_INPROGRESS"] = 'overdue';
$lang["PATIENT_INVOICE_STATUS_INPROGRESS_TIME"] = 'since';
$lang["PATIENT_INVOICE_STATUS_FINISHED"] = 'paid';
$lang["PATIENT_INVOICE_STATUS_FINISHED_TIME"] = 'on';

$lang["PATIENT_INVOICE_DURATION"] = 'Duration';
$lang["PATIENT_INVOICE_LIST"] = 'Services';
$lang["PATIENT_INVOICE_TOTALS"] = 'Totals';

$lang["PATIENT_INVOICE_NOTES"] = 'Notes';

//$lang["PATIENT_INVOICE_GOALS"] = 'Einzelziele';
//$lang["PATIENT_INVOICE_TASKS_START"] = 'Start';
//$lang["PATIENT_INVOICE_TASKS_END"] = 'Ende';

//$lang["PATIENT_INVOICE_POSPONED"] = 'verschoben';

$lang["PATIENT_INVOICE_HELP"] = 'manual_patienten_rechnungen.pdf';

$lang["PATIENT_PRINT_INVOICE"] = 'invoice.png';
$lang["PATIENT_PRINT_REMINDER"] = 'mahnung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/invoices/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>