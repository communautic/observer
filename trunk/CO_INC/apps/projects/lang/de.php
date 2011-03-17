<?php
// App name
$projects_name = "Projekte";

// Left
$lang["PROJECT_FOLDER"] = 'Ordner';
$lang["PROJECT_FOLDER_NEW"] = 'Neuer Ordner';
$lang["PROJECT_PROJECTS"] = 'Projekte';
$lang["PROJECT_NEW"] = 'Neues Projekt';

// Folder Right
$lang["PROJECT_FOLDER_PROJECTS_CREATED"] = 'Projekte insgesamt';
$lang["PROJECT_FOLDER_PROJECTS_PLANNED"] = 'Projekte in Planung';
$lang["PROJECT_FOLDER_PROJECTS_RUNNING"] = 'Projekte in Arbeit';
$lang["PROJECT_FOLDER_PROJECTS_FINISHED"] = 'Projekte abgeschlossen';
$lang["PROJECT_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["PROJECT_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["PROJECT_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["PROJECT_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["PROJECT_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["PROJECT_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';

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
$lang["PROJECT_PHASES"] = 'Phasen';
$lang["PROJECT_MEETINGS"] = 'Besprechungen';

$lang["PROJECT_HANDBOOK"] = 'Projekthandbuch';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>