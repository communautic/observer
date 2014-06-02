<?php
$trainings_feedbacks_name = "Feedbacks";

$lang["TRAINING_FEEDBACK_TITLE"] = 'Einzelfeedback';
$lang["TRAINING_FEEDBACK_TITLE_STATISTICS"] = 'Gesamtstatistik';
$lang["TRAINING_FEEDBACKS"] = 'Feedbacks';

$lang["TRAINING_FEEDBACK_NEW"] = 'Neue Feedback';
$lang["TRAINING_FEEDBACK_ACTION_NEW"] = 'neue Feedback anlegen';
$lang["TRAINING_FEEDBACK_TASK_NEW"] = 'Neues Einzelziel';
//define('FEEDBACK_RELATES_TO', 'bezogen auf');
$lang["TRAINING_FEEDBACK_DATE"] = 'Datum';
$lang["TRAINING_FEEDBACK_PLACE"] = 'Ort';
$lang["TRAINING_FEEDBACK_TIME_START"] = 'Start';
$lang["TRAINING_FEEDBACK_TIME_END"] = 'Ende';

$lang["TRAINING_FEEDBACK_ATTENDEES"] = 'Teilnehmer';
$lang["TRAINING_FEEDBACK_MANAGEMENT"] = 'Protokollführer';
$lang["TRAINING_FEEDBACK_DESCRIPTION"] = 'Beschreibung';

$lang["TRAINING_FEEDBACK_QUESTIONS_INTRO"] = 'Beurteilen Sie zum Abschluss bitte die Qualitaet der Trainingsveranstaltung durch das Anwaehlen einer jeweiligen Kategorie pro Fragestellung (von 0 - Unzureichend bis 5 - Ausgezeichnet). Unter Punkt 6 finden Sie weiters die Möglichkeit, persönlich gehaltene Bemerkungen abzugeben. Danke für Ihre Meinung, sie ist uns wichtig!';
$lang["TRAINING_FEEDBACK_QUESTION_1"] = 'Wie sehr hat Ihnen die Veranstaltung insgesamt zugesagt?';
$lang["TRAINING_FEEDBACK_QUESTION_2"] = 'Wie bewerten Sie die Relation Zeitaufwand-Informationsgewinn?';
$lang["TRAINING_FEEDBACK_QUESTION_3"] = 'Wie qualifiziert wirkt der Trainer?';
$lang["TRAINING_FEEDBACK_QUESTION_4"] = 'Wie hoch ist der Praxiswert der angebotenen Inhalte einzuschaetzen?';
$lang["TRAINING_FEEDBACK_QUESTION_5"] = 'Wurde das persönliche Weiterbildungsziel erreicht?';
$lang["TRAINING_FEEDBACK_QUESTION_6"] = 'Weitere Kommentare';
$lang["TRAINING_FEEDBACK_SUBMIT"] = 'Abschicken';

$lang["TRAINING_FEEDBACK_GOALS"] = 'Einzelziele';
$lang["TRAINING_FEEDBACK_TASKS_START"] = 'Start';
$lang["TRAINING_FEEDBACK_TASKS_END"] = 'Ende';

$lang["TRAINING_FEEDBACK_POSPONED"] = 'verschoben';

$lang["TRAINING_FEEDBACK_HELP"] = 'manual_trainings_feedbacks.pdf';

$lang["TRAINING_PRINT_FEEDBACK"] = 'feedback.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/feedbacks/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>