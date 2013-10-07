<?php
$patients_invoices_name = "Invoices";

$lang["PATIENT_INVOICE_TITLE"] = 'Invoice';
$lang["PATIENT_INVOICE_TITLE_STATISTICS"] = 'Totals';
$lang["PATIENT_INVOICES"] = 'Invoices';

$lang["PATIENT_INVOICE_NEW"] = 'New Invoice';
$lang["PATIENT_INVOICE_ACTION_NEW"] = 'new Invoice';
$lang["PATIENT_INVOICE_TASK_NEW"] = 'Neues Einzelziel';
//define('INVOICE_RELATES_TO', 'bezogen auf');
$lang["PATIENT_INVOICE_DATE"] = 'Datum';
$lang["PATIENT_INVOICE_PLACE"] = 'Ort';
$lang["PATIENT_INVOICE_TIME_START"] = 'Start';
$lang["PATIENT_INVOICE_TIME_END"] = 'Ende';

$lang["PATIENT_INVOICE_ATTENDEES"] = 'Teilnehmer';
$lang["PATIENT_INVOICE_MANAGEMENT"] = 'Protokollführer';
$lang["PATIENT_INVOICE_DESCRIPTION"] = 'Beschreibung';

$lang["PATIENT_INVOICE_QUESTIONS_INTRO"] = 'Beurteilen Sie zum Abschluss bitte die Qualitaet der Patientsveranstaltung durch das Anwaehlen einer jeweiligen Kategorie pro Fragestellung (von 0 - Unzureichend bis 5 - Ausgezeichnet). Unter Punkt 6 finden Sie weiters die Möglichkeit, persönlich gehaltene Bemerkungen abzugeben. Danke für Ihre Meinung, sie ist uns wichtig!';
$lang["PATIENT_INVOICE_QUESTION_1"] = 'Wie sehr hat Ihnen die Veranstaltung insgesamt zugesagt?';
$lang["PATIENT_INVOICE_QUESTION_2"] = 'Wie bewerten Sie die Relation Zeitaufwand-Informationsgewinn?';
$lang["PATIENT_INVOICE_QUESTION_3"] = 'Wie qualifiziert wirkt der Trainer?';
$lang["PATIENT_INVOICE_QUESTION_4"] = 'Wie hoch ist der Praxiswert der angebotenen Inhalte einzuschaetzen?';
$lang["PATIENT_INVOICE_QUESTION_5"] = 'Wurde das persönliche Weiterbildungsziel erreicht?';
$lang["PATIENT_INVOICE_QUESTION_6"] = 'Weitere Kommentare';
$lang["PATIENT_INVOICE_SUBMIT"] = 'Abschicken';

$lang["PATIENT_INVOICE_GOALS"] = 'Einzelziele';
$lang["PATIENT_INVOICE_TASKS_START"] = 'Start';
$lang["PATIENT_INVOICE_TASKS_END"] = 'Ende';

$lang["PATIENT_INVOICE_POSPONED"] = 'verschoben';

$lang["PATIENT_INVOICE_HELP"] = 'manual_patienten_rechnungen.pdf';

$lang["PATIENT_PRINT_INVOICE"] = 'invoice.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/invoices/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>