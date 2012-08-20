<?php
$employees_objectives_name = "Zielvereinbarungen";

$lang["EMPLOYEE_OBJECTIVE_TITLE"] = 'Zielvereinbarung';
$lang["EMPLOYEE_OBJECTIVES"] = 'Zielvereinbarungen';

$lang["EMPLOYEE_OBJECTIVE_NEW"] = 'Neue Zielvereinbarung';
$lang["EMPLOYEE_OBJECTIVE_ACTION_NEW"] = 'neue Zielvereinbarung anlegen';
$lang["EMPLOYEE_OBJECTIVE_TASK_NEW"] = 'Neues Einzelziel';
//define('OBJECTIVE_RELATES_TO', 'bezogen auf');
$lang["EMPLOYEE_OBJECTIVE_DATE"] = 'Datum';
$lang["EMPLOYEE_OBJECTIVE_PLACE"] = 'Ort';
$lang["EMPLOYEE_OBJECTIVE_TIME_START"] = 'Start';
$lang["EMPLOYEE_OBJECTIVE_TIME_END"] = 'Ende';

$lang["EMPLOYEE_OBJECTIVE_ATTENDEES"] = 'Teilnehmer';
$lang["EMPLOYEE_OBJECTIVE_MANAGEMENT"] = 'Protokollführer';

$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_1"] = '1. Sorgfalt, Genauigkeit, Umsicht, Übersicht, Prioritäten setzen';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_2"] = '2. Eigeninitiative, selbstständiges Arbeiten, Mitdenken, Vorausdenken';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_3"] = '3. Zuverlässigkeit, Pünktlichkeit, Häufigkeit des Krankenstandes';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_4"] = '4. Kostenbewusstsein, Umgang mit Firmeneigentum';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_5"] = '5. Kooperationsbereitschaft, Teamfähigkeit, Freundlichkeit, Auftreten gegenüber Kunden, Kollegen und Vorgesetzten';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_6"] = '6. Termintreue';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_7"] = '7. Problemlösungskompetenz';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_8"] = '8. Bereitschaft, Arbeitszeit an die betrieblichen Erfordernisse anzupassen';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_9"] = '9. Trennung der Privatsphäre von der Arbeit';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_10"] = '10. Bereitschaft zur personlichen Weiterentwicklung';

$lang["EMPLOYEE_OBJECTIVE_GOALS"] = 'Einzelziele';
$lang["EMPLOYEE_OBJECTIVE_TASKS_START"] = 'Start';
$lang["EMPLOYEE_OBJECTIVE_TASKS_END"] = 'Ende';

$lang["EMPLOYEE_OBJECTIVE_POSPONED"] = 'verschoben';

$lang["EMPLOYEE_OBJECTIVE_HELP"] = 'manual_reklamationen_besprechungen.pdf';

$lang["EMPLOYEE_PRINT_OBJECTIVE"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/objectives/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>