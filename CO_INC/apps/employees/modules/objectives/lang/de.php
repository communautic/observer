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
$lang["EMPLOYEE_OBJECTIVE_DESCRIPTION"] = 'Beschreibung';

$lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_1"] = '1. Sind Sie zufrieden mit Ihrem Aufgabengebiet?';
$lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_2"] = '2. Fühlen Sie sich gemäß Ihren Kompetenzen und Vorstellungen richtig positioniert?';
$lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_3"] = '3. Wie gut ist Ihr Arbeitsplatz für Ihre Tätigkeit ausgerüstet?';
$lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_4"] = '4. Fühlen Sie sich von mir gut geführt?';
$lang["EMPLOYEE_OBJECTIVE_TAB1_QUESTION_5"] = '5. Wie wohl fühlen Sie sich im Kreise Ihrer Kollegen/Ihres Teams?';

$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT1_QUESTION_1"] = '1. Sorgfalt, Genauigkeit, Übersicht, Termintreue';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT2_QUESTION_1"] = '1. Problemlösung, Umsetzung, Verantwortung übernehmen';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT3_QUESTION_1"] = '1. Sorgfalt, Genauigkeit, Übersicht, Termintreue';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT1_QUESTION_2"] = '2. Selbstständiges Arbeiten, Mit- und Vorausdenken, Prioritäten setzen';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT2_QUESTION_2"] = '2. Mitarbeiterführung, Teamperformance';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT3_QUESTION_2"] = '2. Selbstständiges Arbeiten, Mit- und Vorausdenken, Prioritäten setzen';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT1_QUESTION_3"] = '3. Kooperationsbereitschaft, Teamfähigkeit';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT2_QUESTION_3"] = '3. Eigeninitiative, Innovationsbereitschaft';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT3_QUESTION_3"] = '3. Kooperationsbereitschaft, Teamfähigkeit';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT1_QUESTION_4"] = '4. Eigeninitiative, Innovationsbereitschaft';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT2_QUESTION_4"] = '4. Konzeptfähigkeit, Planung, Analyse';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT3_QUESTION_4"] = '4. Eigeninitiative, Innovationsbereitschaft';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT1_QUESTION_5"] = '5. Bereitschaft zur persönlichen Weiterentwicklung';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT2_QUESTION_5"] = '5. Strategisches- und unternehmerisches Denken';
$lang["EMPLOYEE_OBJECTIVE_TAB2_CAT3_QUESTION_5"] = '5. Bereitschaft zur persönlichen Weiterentwicklung';
/*$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_6"] = '6. Termintreue';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_7"] = '7. Problemlösungskompetenz';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_8"] = '8. Bereitschaft, Arbeitszeit an die betrieblichen Erfordernisse anzupassen';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_9"] = '9. Trennung der Privatsphäre von der Arbeit';
$lang["EMPLOYEE_OBJECTIVE_TAB2_QUESTION_10"] = '10. Bereitschaft zur personlichen Weiterentwicklung';*/

$lang["EMPLOYEE_OBJECTIVE_GOALS"] = 'Einzelziele';
$lang["EMPLOYEE_OBJECTIVE_TASKS_START"] = 'Start';
$lang["EMPLOYEE_OBJECTIVE_TASKS_END"] = 'Ende';

$lang["EMPLOYEE_OBJECTIVE_POSPONED"] = 'verschoben';

$lang["EMPLOYEE_OBJECTIVE_HELP"] = 'manual_mitarbeiter_zielvereinbarungen.pdf';

$lang["EMPLOYEE_PRINT_OBJECTIVE"] = 'zielvereinbarung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/objectives/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>