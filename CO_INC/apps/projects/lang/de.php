<?php
// App name
$projects_name = "Projekte";

// Left
$lang["PROJECT_FOLDER"] = 'Ordner';
$lang["PROJECT_FOLDER_NEW"] = 'Neuer Ordner';
$lang["PROJECT_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["PROJECT_PROJECTS"] = 'Projekte';
$lang["PROJECT_NEW"] = 'Neues Projekt';
$lang["PROJECT_ACTION_NEW"] = 'neues Projekt anlegen';

// Folder Right
$lang["PROJECT_FOLDER_PROJECTS_CREATED"] = 'Projekte insgesamt';
$lang["PROJECT_FOLDER_PROJECTS_PLANNED"] = 'Projekte in Planung';
$lang["PROJECT_FOLDER_PROJECTS_RUNNING"] = 'Projekte in Arbeit';
$lang["PROJECT_FOLDER_PROJECTS_FINISHED"] = 'Projekte abgeschlossen';
$lang["PROJECT_FOLDER_PROJECTS_STOPPED"] = 'Projekte abgebrochen';
$lang["PROJECT_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["PROJECT_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["PROJECT_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["PROJECT_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["PROJECT_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["PROJECT_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["PROJECT_FOLDER_CHART_STATUS"] = 'Status';

// Project Right
$lang["PROJECT_TITLE"] = 'Projekt';
$lang['PROJECT_KICKOFF'] = 'Kick Off';

$lang["PROJECT_CLIENT"] = 'Projektauftraggeber';
$lang["PROJECT_MANAGEMENT"] = 'Projektleitung';
$lang["PROJECT_TEAM"] = 'Projektteam';
$lang["PROJECT_DESCRIPTION"] = 'Beschreibung';

$lang["PROJECT_STATUS_PLANNED"] = 'in Planung seit';
$lang["PROJECT_STATUS_INPROGRESS"] = 'in Arbeit seit';
$lang["PROJECT_STATUS_FINISHED"] = 'abgeschlossen am';
$lang["PROJECT_STATUS_STOPPED"] = 'abgebrochen am';

$lang["PROJECT_STATUS_PLANNED_TEXT"] = 'in Planung';
$lang["PROJECT_STATUS_INPROGRESS_TEXT"] = 'in Arbeit';
$lang["PROJECT_STATUS_FINISHED_TEXT"] = 'abgeschlossen';
$lang["PROJECT_STATUS_STOPPED_TEXT"] = 'abgebrochen';

$lang["PROJECT_HANDBOOK"] = 'Projekthandbuch';

$lang["PROJECT_HELP"] = 'manual_projekte_projekte.pdf';
$lang["PROJECT_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_PROJECT_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_PROJECT"] = 'projekt.png';
$lang["PRINT_PROJECT_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>