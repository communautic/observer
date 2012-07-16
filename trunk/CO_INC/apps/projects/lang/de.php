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
$lang["PROJECT_FOLDER_TAB_PROJECTS"] = 'Projektliste';
$lang["PROJECT_FOLDER_TAB_MULTIVIEW"] = 'Multiprojektübersicht';
$lang["PROJECT_FOLDER_TAB_STATUS"] = 'Ordnerstatus';

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

$lang["PROJECT_HANDBOOK"] = 'Projekthandbuch';

$lang["PROJECT_HELP"] = 'manual_projekte_projekte.pdf';
$lang["PROJECT_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_PROJECT_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_PROJECT"] = 'projekt.png';
$lang["PRINT_PROJECT_FOLDER"] = 'ordner.png';

// Dektop Widget
$lang["PROJECT_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["PROJECT_WIDGET_TITLE_MILESTONE"] 	=	'Meilenstein';
$lang["PROJECT_WIDGET_REMINDER_MILESTONE"] 	= 	'Abschluss "%1$s" ist für <span class="yellow">morgen</span> geplant';

$lang["PROJECT_WIDGET_TITLE_TASK"] 			=	'Arbeitspaket';
$lang["PROJECT_WIDGET_REMINDER_TASK"] 		= 	'Abschluss "%1$s" ist für <span class="yellow">morgen</span> geplant';

$lang["PROJECT_WIDGET_TITLE_KICKOFF"] 		=	'Kick Off';
$lang["PROJECT_WIDGET_REMINDER_KICKOFF"] 	= 	'für "%1$s" ist mit <span class="yellow">morgen</span> geplant';

$lang["PROJECT_WIDGET_ALERT_TASK"] 			= 	'"%1$s" ist <span class="yellow">außer Plan</span>';
$lang["PROJECT_WIDGET_ALERT_MILESTONE"] 	= 	'"%1$s" ist <span class="yellow">außer Plan</span>';

$lang["PROJECT_WIDGET_TITLE_PROJECT"]		=	'Freischaltung';
$lang["PROJECT_WIDGET_INVITATION_ADMIN"]	=	'als <span class="yellow">Administrator</span> für "%1$s"';
$lang["PROJECT_WIDGET_INVITATION_GUEST"]	=	'als <span class="yellow">Beobachter</span> für "%1$s"';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>