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

// Folder Right
$lang["TRAINING_FOLDER_TRAININGS_CREATED"] = 'Trainings insgesamt';
$lang["TRAINING_FOLDER_TRAININGS_PLANNED"] = 'Trainings in Planung';
$lang["TRAINING_FOLDER_TRAININGS_RUNNING"] = 'Trainings in Arbeit';
$lang["TRAINING_FOLDER_TRAININGS_FINISHED"] = 'Trainings abgeschlossen';
$lang["TRAINING_FOLDER_TRAININGS_STOPPED"] = 'Trainings abgebrochen';
$lang["TRAINING_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["TRAINING_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["TRAINING_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["TRAINING_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["TRAINING_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["TRAINING_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
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

$lang['TRAINING_INVITATION_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Wir laden Sie ein zur Veranstaltung:</p>' .
										'<p style="font-face: Arial, Verdana; font-size: small"><b>"%2$s"</b></p>' .
    									'<table border="0" cellspacing="0" cellpadding="0"><tr><td width="170" style="font-face: Arial, Verdana; font-size: small; color: #999999;">Trainingsanbieter</td><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">%3$s</td></tr><tr><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">TrainerIn</td><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">%4$s%5$s</td></tr><tr><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">Trainingsart</td><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">%6$s</td></tr></table>' .
										'<p style="font-face: Arial, Verdana; font-size: small">Veranstaltungsdaten:</p>' .
										'%7$s' .
										'<p style="font-face: Arial, Verdana; font-size: small;">&nbsp;</p>' .
										'<p style="font-face: Arial, Verdana; font-size: small;">Bitte bestätigen Sie Ihre Teilnahme unter folgendem Link:</p>' .
										'<p style="font-face: Arial, Verdana; font-size: small"><a href="%1$s">%1$s</a><br />' .
										'<p style="font-face: Arial, Verdana; font-size: small;">&nbsp;</p>';


// $training->date1, $training->date2, $training->date3, $training->time1, $training->time2, $training->time3, $training->time4, $training->place1, $training->place1_ct, $training->place2, $training->place2ct, $training->text1, $training->text2, $training->text3, $training->registration_end
// Vortrag
$lang['TRAINING_INVITATION_EMAIL_CAT_1'] =	'<table border="0" cellspacing="0" cellpadding="0"><tr><td width="170" style="font-face: Arial, Verdana; font-size: small; color: #999999;">Vortrag</td><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">%1$s</td></tr><tr><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">Start</td><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">%4$s</td></tr><tr><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">End</td><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">%5$s</td></tr><tr><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">Ort</td><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">%8$s%9$s</td></tr><tr><td style="font-face: Arial, Verdana; font-size: small; color: #999999;">&nbsp;</td><td style="font-face: Arial, Verdana; font-size: small">&nbsp;</td></tr><tr><td style="font-face: Arial, Verdana; font-size: small;"><b>Anmeldeschluss</b></td><td style="font-face: Arial, Verdana; font-size: small;">%15$s</td></tr></table>';


$lang['TRAINING_KICKOFF'] = 'Reklamationseingang';


$lang["TRAINING_TRAININGCATMORE"] = 'Reklamationsquelle';
$lang["TRAINING_CAT"] = 'Mangelkategorie';
$lang["TRAINING_CAT_MORE"] = 'Reklamationsmuster';
$lang["TRAINING_PRODUCT_NUMBER"] = 'Produktnummer';
$lang["TRAINING_PRODUCT"] = 'Produktbezeichnung';
$lang["TRAINING_CHARGE"] = 'Charge';
$lang["TRAINING_NUMBER"] = 'Menge';


$lang["TRAINING_HELP"] = 'manual_reklamationen_reklamationen.pdf';
$lang["TRAINING_FOLDER_HELP"] = 'manual_reklamationen_ordner.pdf';

// Print images
$lang["PRINT_TRAINING"] = 'reklamation.png';
$lang["PRINT_TRAINING_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>