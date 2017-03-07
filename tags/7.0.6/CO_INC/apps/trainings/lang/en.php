<?php
// App name
$trainings_name = "Trainings";
$lang["trainings_name"] = 'Trainings';

// Left
$lang["TRAINING_FOLDER"] = 'Folder';
$lang["TRAINING_FOLDER_NEW"] = 'New Folder';
$lang["TRAINING_FOLDER_ACTION_NEW"] = 'create new Folder';
$lang["TRAINING_TRAININGS"] = 'Trainings';
$lang["TRAINING_NEW"] = 'New Training';
$lang["TRAINING_ACTION_NEW"] = 'create new Training';

$lang["TRAINING_FOLDER_TAB_TRAININGS"] = "List of trainings";
$lang["TRAINING_FOLDER_TAB_MULTIVIEW"] = "Calendar";
$lang["TRAINING_FOLDER_TAB_STATUS"] = "Performance";
$lang['TRAINING_TIMELINE_TIME'] = "Days";
$lang['TRAINING_TIMELINE_ACTION'] = "Training";

// Folder Right
$lang["TRAINING_FOLDER_TRAININGS_CREATED"] = 'Total Trainings';
$lang["TRAINING_FOLDER_TRAININGS_PLANNED"] = 'Planned Trainings';
$lang["TRAINING_FOLDER_TRAININGS_RUNNING"] = 'Trainings in Progress';
$lang["TRAINING_FOLDER_TRAININGS_FINISHED"] = 'Trainings completed';
$lang["TRAINING_FOLDER_TRAININGS_STOPPED"] = 'Trainings cancelled';
$lang["TRAINING_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["TRAINING_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["TRAINING_FOLDER_CHART_STABILITY"] = 'Umsetzungsstabilitaet aktuell';
$lang["TRAINING_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["TRAINING_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["TRAINING_FOLDER_CHART_FEEDBACKS"] = 'Feedbacks';
$lang["TRAINING_FOLDER_CHART_STATUS"] = 'Status';

// Training Right
$lang["TRAINING_TITLE"] = 'Training';

$lang["TRAINING_MANAGEMENT"] = 'Organisation';
$lang["TRAINING_COMPANY"] = 'Trainingsanbieter';
$lang["TRAINING_TEAM"] = 'TrainerIn';
$lang["TRAINING_TRAININGCAT"] = 'Trainingsart';
$lang["TRAINING_COSTS"] = 'Teilnahmekosten';

$lang["TRAINING_TIME_START"] = 'Start';
$lang["TRAINING_TIME_END"] = 'Ende';
$lang["TRAINING_PLACE"] = 'Ort';
$lang["TRAINING_REGISTRATION_END"] = 'Anmeldeschluss';
$lang["TRAINING_DESCRIPTION"] = 'Beschreibung';

$lang["TRAINING_MEMBER"] = 'TeilnehmerInnen';

$lang['TRAINING_MEMBER_LOG_0'] = 'Einladung confirmed';
$lang['TRAINING_MEMBER_LOG_1'] = 'Einladung versendet';
$lang['TRAINING_MEMBER_LOG_2'] = 'Anmeldung confirmed';
$lang['TRAINING_MEMBER_LOG_3'] = 'Anmeldung erfolgt';
$lang['TRAINING_MEMBER_LOG_4'] = 'Abmeldung erfolgt';
$lang['TRAINING_MEMBER_LOG_5'] = 'Teilnahme confirmed';
$lang['TRAINING_MEMBER_LOG_6'] = 'Teilnahme deleted';
$lang['TRAINING_MEMBER_LOG_7'] = 'Feedback versendet';
$lang['TRAINING_MEMBER_LOG_8'] = 'Einladung deleted';
$lang['TRAINING_MEMBER_LOG_9'] = 'Anmeldung deleted';
$lang['TRAINING_MEMBER_LOG_10'] = 'Feedback deleted';
$lang['TRAINING_MEMBER_LOG_11'] = 'Feedback given';

$lang['TRAINING_INVITATION_RESPONSE_ACCEPT'] = 'Sie haben sich zur Veranstaltung angemeldet!';
$lang['TRAINING_INVITATION_RESPONSE_ACCEPT2'] = 'Sie wurden zur Veranstaltung angemeldet!';
$lang['TRAINING_INVITATION_RESPONSE_DECLINE'] = 'Sie haben sich zur Veranstaltung nicht angemeldet!';
$lang['TRAINING_INVITATION_RESPONSE_DECLINE2'] = 'Sie wurden zur Veranstaltung nicht angemeldet!';

$lang["TRAINING_TIMELINE_TRAINING_PLAN"] = "Balkenplan";

$lang["TRAINING_BUTTON_ACCEPT"] = 'button_accept.jpg';
$lang["TRAINING_BUTTON_DECLINE"] = 'button_decline.jpg';
$lang["TRAINING_BUTTON_FEEDBACK"] = 'button_feedback.jpg';
$lang["TRAINING_BUTTON_FEEDBACK_SUBMIT"] = 'button_feedback_submit.jpg';

$lang["TRAINING_HANDBOOK"] = 'Trainingskatalog';


$lang["TRAINING_HELP"] = 'manual_trainings_trainings.pdf';
$lang["TRAINING_FOLDER_HELP"] = 'manual_trainings_ordner.pdf';

// Print images
$lang["PRINT_TRAINING_MANUAL"] = 'katalog.png';
$lang["PRINT_TRAINING"] = 'training.png';
$lang["PRINT_TRAINING_MEMBERS"] = 'teilnehmerliste.png';
$lang["PRINT_TRAINING_FOLDER"] = 'ordner.png';

$lang["TRAINING_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["TRAINING_WIDGET_TITLE_KICKOFF"] 		=	'Anmeldeschluss';
$lang["TRAINING_WIDGET_REMINDER_KICKOFF"] 	= 	'for "%1$s" ist mit <span class="yellow">morgen</span> geplant';
$lang["TRAINING_WIDGET_TITLE_START"] 		=	'Trainingsstart';
$lang["TRAINING_WIDGET_REMINDER_START"] 	= 	'for "%1$s" ist mit <span class="yellow">morgen</span> geplant';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>