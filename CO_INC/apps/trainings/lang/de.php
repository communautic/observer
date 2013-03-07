<?php
// App name
$trainings_name = "Trainings";
$lang["trainings_name"] = 'Trainings';

// Left
$lang["TRAINING_FOLDER"] = 'Ordner';
$lang["TRAINING_FOLDER_NEW"] = 'Neuer Ordner';
$lang["TRAINING_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["TRAINING_TRAININGS"] = 'Trainings';
$lang["TRAINING_NEW"] = 'Neues Training';
$lang["TRAINING_ACTION_NEW"] = 'neues Training anlegen';

$lang["TRAINING_FOLDER_TAB_TRAININGS"] = "Trainingsliste";
$lang["TRAINING_FOLDER_TAB_MULTIVIEW"] = "Kalernderübersicht";
$lang["TRAINING_FOLDER_TAB_STATUS"] = "Ordnerstatus";
$lang['TRAINING_TIMELINE_TIME'] = "Tage";
$lang['TRAINING_TIMELINE_ACTION'] = "Vorgang";

// Folder Right
$lang["TRAINING_FOLDER_TRAININGS_CREATED"] = 'Trainings insgesamt';
$lang["TRAINING_FOLDER_TRAININGS_PLANNED"] = 'Trainings in Planung';
$lang["TRAINING_FOLDER_TRAININGS_RUNNING"] = 'Trainings in Ausführung';
$lang["TRAINING_FOLDER_TRAININGS_FINISHED"] = 'Trainings abgehalten';
$lang["TRAINING_FOLDER_TRAININGS_STOPPED"] = 'Trainings abgesagt';
$lang["TRAINING_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["TRAINING_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["TRAINING_FOLDER_CHART_STABILITY"] = 'Umsetzungsstabilität aktuell';
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

$lang["TRAINING_TIME_START"] = 'Start';
$lang["TRAINING_TIME_END"] = 'Ende';
$lang["TRAINING_PLACE"] = 'Ort';
$lang["TRAINING_REGISTRATION_END"] = 'Anmeldeschluss';
$lang["TRAINING_DESCRIPTION"] = 'Beschreibung';

$lang["TRAINING_MEMBER"] = 'TeilnehmerInnen';

$lang['TRAINING_MEMBER_LOG_0'] = 'Einladung bestätigt';
$lang['TRAINING_MEMBER_LOG_1'] = 'Einladung versendet';
$lang['TRAINING_MEMBER_LOG_2'] = 'Anmeldung bestätigt';
$lang['TRAINING_MEMBER_LOG_3'] = 'Anmeldung erfolgt';
$lang['TRAINING_MEMBER_LOG_4'] = 'Abmeldung erfolgt';
$lang['TRAINING_MEMBER_LOG_5'] = 'Teilnahme bestätigt';
$lang['TRAINING_MEMBER_LOG_6'] = 'Teilnahme gelöscht';
$lang['TRAINING_MEMBER_LOG_7'] = 'Feedback versendet';
$lang['TRAINING_MEMBER_LOG_8'] = 'Einladung gelöscht';
$lang['TRAINING_MEMBER_LOG_9'] = 'Anmeldung gelöscht';
$lang['TRAINING_MEMBER_LOG_10'] = 'Feedback gelöscht';
$lang['TRAINING_MEMBER_LOG_11'] = 'Feedback durchgeführt';

$lang['TRAINING_INVITATION_RESPONSE_ACCEPT'] = 'Sie haben sich zur Veranstaltung angemeldet!';
$lang['TRAINING_INVITATION_RESPONSE_ACCEPT2'] = 'Sie wurden zur Veranstaltung angemeldet!';
$lang['TRAINING_INVITATION_RESPONSE_DECLINE'] = 'Sie haben sich zur Veranstaltung nicht angemeldet!';
$lang['TRAINING_INVITATION_RESPONSE_DECLINE2'] = 'Sie wurden zur Veranstaltung nicht angemeldet!';

$lang["TRAINING_TIMELINE_TRAINING_PLAN"] = "Balkenplan";


/*$lang["TRAINING_TRAININGCATMORE"] = 'Reklamationsquelle';
$lang["TRAINING_CAT"] = 'Mangelkategorie';
$lang["TRAINING_CAT_MORE"] = 'Reklamationsmuster';
$lang["TRAINING_PRODUCT_NUMBER"] = 'Produktnummer';
$lang["TRAINING_PRODUCT"] = 'Produktbezeichnung';
$lang["TRAINING_CHARGE"] = 'Charge';
$lang["TRAINING_NUMBER"] = 'Menge';*/


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
$lang["TRAINING_WIDGET_REMINDER_KICKOFF"] 	= 	'für "%1$s" ist mit <span class="yellow">morgen</span> geplant';
$lang["TRAINING_WIDGET_TITLE_START"] 		=	'Trainingsstart';
$lang["TRAINING_WIDGET_REMINDER_START"] 	= 	'für "%1$s" ist mit <span class="yellow">morgen</span> geplant';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>