<?php
// App name
$archives_name = "Archiv";
$lang["archives_name"] = "Archiv";

// Left
$lang["ARCHIVE_ARCHIVES"] = 'Archiv';
/*$lang["ARCHIVE_FOLDER"] = 'Ordner';
$lang["ARCHIVE_FOLDER_NEW"] = 'Neuer Ordner';
$lang["ARCHIVE_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';

$lang["ARCHIVE_NEW"] = 'Neues Projekt';
$lang["ARCHIVE_ACTION_NEW"] = 'neues Projekt anlegen';

// Folder Right
$lang["ARCHIVE_FOLDER_TAB_ARCHIVES"] = 'Projektliste';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW"] = 'Multiprojektübersicht';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW_TIME"] = 'Zeitraum';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW_MANAGEMENT"] = 'Leitung';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW_STATUS"] = 'Status';
$lang["ARCHIVE_FOLDER_TAB_STATUS"] = 'Ordnerstatus';

$lang["ARCHIVE_FOLDER_ARCHIVES_CREATED"] = 'Projekte insgesamt';
$lang["ARCHIVE_FOLDER_ARCHIVES_PLANNED"] = 'Projekte in Planung';
$lang["ARCHIVE_FOLDER_ARCHIVES_RUNNING"] = 'Projekte in Arbeit';
$lang["ARCHIVE_FOLDER_ARCHIVES_FINISHED"] = 'Projekte abgeschlossen';
$lang["ARCHIVE_FOLDER_ARCHIVES_STOPPED"] = 'Projekte abgebrochen';
$lang["ARCHIVE_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["ARCHIVE_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["ARCHIVE_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["ARCHIVE_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["ARCHIVE_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["ARCHIVE_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["ARCHIVE_FOLDER_CHART_STATUS"] = 'Status';

// Archive Right
$lang["ARCHIVE_TITLE"] = 'Projekt';
$lang['ARCHIVE_KICKOFF'] = 'Kick Off';

$lang["ARCHIVE_CLIENT"] = 'Projektauftraggeber';
$lang["ARCHIVE_MANAGEMENT"] = 'Projektleitung';
$lang["ARCHIVE_TEAM"] = 'Projektteam';

$lang["ARCHIVE_COSTS_PLAN"] = 'Kosten/Plan';
$lang["ARCHIVE_COSTS_REAL"] = 'Kosten/Ist';

$lang["ARCHIVE_DESCRIPTION"] = 'Beschreibung';

$lang["ARCHIVE_HANDBOOK"] = 'Projekthandbuch';*/

$lang["ARCHIVE_HELP"] = 'manual_archiv.pdf';
/*$lang["ARCHIVE_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_ARCHIVE_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_ARCHIVE"] = 'projekt.png';
$lang["PRINT_ARCHIVE_FOLDER"] = 'ordner.png';

// Dektop Widget
$lang["ARCHIVE_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["ARCHIVE_WIDGET_TITLE_MILESTONE"] 	=	'Meilenstein';
$lang["ARCHIVE_WIDGET_REMINDER_MILESTONE"] 	= 	'Abschluss "%1$s" im Projekt "%2$s" ist für <span class="yellow">morgen</span> geplant';

$lang["ARCHIVE_WIDGET_TITLE_TASK"] 			=	'Arbeitspaket';
$lang["ARCHIVE_WIDGET_REMINDER_TASK"] 		= 	'Abschluss "%1$s" im Projekt "%2$s" ist für <span class="yellow">morgen</span> geplant';

$lang["ARCHIVE_WIDGET_TITLE_KICKOFF"] 		=	'Kick Off';
$lang["ARCHIVE_WIDGET_REMINDER_KICKOFF"] 	= 	'für "%1$s" ist mit <span class="yellow">morgen</span> geplant';

$lang["ARCHIVE_WIDGET_ALERT_TASK"] 			= 	'"%1$s" im Projekt "%2$s" ist <span class="yellow">außer Plan</span>';
$lang["ARCHIVE_WIDGET_ALERT_MILESTONE"] 	= 	'"%1$s" im Projekt "%2$s" ist <span class="yellow">außer Plan</span>';

$lang["ARCHIVE_WIDGET_TITLE_ARCHIVE"]		=	'Freischaltung';
$lang["ARCHIVE_WIDGET_INVITATION_ADMIN"]	=	'als <span class="yellow">Administrator</span> für "%1$s"';
$lang["ARCHIVE_WIDGET_INVITATION_GUEST"]	=	'als <span class="yellow">Beobachter</span> für "%1$s"';

$lang["ARCHIVE_WIDGET_ARCHIVELINK_TITLE"]	=	'Terminänderung';
$lang["ARCHIVE_WIDGET_ARCHIVELINK_STARTEND"]=	'Start- & Endtermin für das Projekt "%1$s" wurde verändert';
$lang["ARCHIVE_WIDGET_ARCHIVELINK_START"]	=	'Der Starttermin für das Projekt "%1$s" wurde verändert';
$lang["ARCHIVE_WIDGET_ARCHIVELINK_END"]		=	'Der Endtermin für das Projekt "%1$s" wurde verändert';

$lang["ARCHIVE_WIDGET_ARCHIVELINK_NOTICE_TITLE"]	=	'Projektlink';
$lang["ARCHIVE_WIDGET_ARCHIVELINK_NOTICE"]=	'Ihr Projekt "%1$s" wurde in den Projektplan von "%2$s" miteingebunden';*/

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/archives/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>