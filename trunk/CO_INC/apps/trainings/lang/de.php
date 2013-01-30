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
$lang["TRAINING_CLIENT"] = 'Trainingsanbieter';
$lang["TRAINING_TEAM"] = 'TrainerIn';
$lang["TRAINING_TRAININGCAT"] = 'Trainingsart';

$lang['TRAINING_KICKOFF'] = 'Reklamationseingang';


$lang["TRAINING_TRAININGCATMORE"] = 'Reklamationsquelle';
$lang["TRAINING_CAT"] = 'Mangelkategorie';
$lang["TRAINING_CAT_MORE"] = 'Reklamationsmuster';
$lang["TRAINING_PRODUCT_NUMBER"] = 'Produktnummer';
$lang["TRAINING_PRODUCT"] = 'Produktbezeichnung';
$lang["TRAINING_CHARGE"] = 'Charge';
$lang["TRAINING_NUMBER"] = 'Menge';
$lang["TRAINING_DESCRIPTION"] = 'Notiz';

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