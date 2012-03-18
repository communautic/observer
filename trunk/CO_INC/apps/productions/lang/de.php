<?php
// App name
$productions_name = "Produktionen";

// Left
$lang["PRODUCTION_FOLDER"] = 'Ordner';
$lang["PRODUCTION_FOLDER_NEW"] = 'Neuer Ordner';
$lang["PRODUCTION_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["PRODUCTION_PRODUCTIONS"] = 'Produktionen';
$lang["PRODUCTION_NEW"] = 'Neue Produktion';
$lang["PRODUCTION_ACTION_NEW"] = 'neue Produktion anlegen';

// Folder Right
$lang["PRODUCTION_FOLDER_TAB_PRODUCTIONS"] = 'Projektliste';
$lang["PRODUCTION_FOLDER_TAB_MULTIVIEW"] = 'Multiprojektübersicht';
$lang["PRODUCTION_FOLDER_TAB_STATUS"] = 'Ordnerstatus';

$lang["PRODUCTION_FOLDER_PRODUCTIONS_CREATED"] = 'Produktionen insgesamt';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_PLANNED"] = 'in Planung';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_RUNNING"] = 'in Arbeit';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_FINISHED"] = 'abgeschlossen';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_STOPPED"] = 'abgebrochen';
$lang["PRODUCTION_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["PRODUCTION_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["PRODUCTION_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["PRODUCTION_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["PRODUCTION_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["PRODUCTION_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["PRODUCTION_FOLDER_CHART_STATUS"] = 'Status';

// Production Right
$lang["PRODUCTION_TITLE"] = 'Produktion';
$lang['PRODUCTION_KICKOFF'] = 'Kick Off';

$lang["PRODUCTION_CLIENT"] = 'Projektauftraggeber';
$lang["PRODUCTION_MANAGEMENT"] = 'Projektleitung';
$lang["PRODUCTION_TEAM"] = 'Projektteam';
$lang["PRODUCTION_DESCRIPTION"] = 'Beschreibung';

$lang["PRODUCTION_STATUS_PLANNED"] = 'in Planung seit';
$lang["PRODUCTION_STATUS_INPROGRESS"] = 'in Arbeit seit';
$lang["PRODUCTION_STATUS_FINISHED"] = 'abgeschlossen am';
$lang["PRODUCTION_STATUS_STOPPED"] = 'abgebrochen am';

$lang["PRODUCTION_STATUS_PLANNED_TEXT"] = 'in Planung';
$lang["PRODUCTION_STATUS_INPROGRESS_TEXT"] = 'in Arbeit';
$lang["PRODUCTION_STATUS_FINISHED_TEXT"] = 'abgeschlossen';
$lang["PRODUCTION_STATUS_STOPPED_TEXT"] = 'abgebrochen';

$lang["PRODUCTION_HANDBOOK"] = 'Projekthandbuch';

$lang["PRODUCTION_HELP"] = 'manual_projekte_projekte.pdf';
$lang["PRODUCTION_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_PRODUCTION_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_PRODUCTION"] = 'projekt.png';
$lang["PRINT_PRODUCTION_FOLDER"] = 'ordner.png';

// Dektop Widget
$lang["PRODUCTION_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["PRODUCTION_WIDGET_TITLE_MILESTONE"] 	=	'Meilenstein';
$lang["PRODUCTION_WIDGET_REMINDER_MILESTONE"] 	= 	'Für <span class="yellow">morgen</span> ist die Erreichung des Meilensteins "%1$s" in der Produktion "%2$s" geplant';

$lang["PRODUCTION_WIDGET_TITLE_TASK"] 			=	'Arbeitspaket';
$lang["PRODUCTION_WIDGET_REMINDER_TASK"] 		= 	'Für <span class="yellow">morgen</span> ist die Erreichung des Arbeitspaketes "%1$s" in der Produktion "%2$s" geplant';

$lang["PRODUCTION_WIDGET_TITLE_KICKOFF"] 		=	'Kick Off';
$lang["PRODUCTION_WIDGET_REMINDER_KICKOFF"] 	= 	'Für <span class="yellow">morgen</span> ist der Kick Off der Produktion "%1$s" geplant';

$lang["PRODUCTION_WIDGET_ALERT_TASK"] 			= 	'Der Arbeitspaket Fälligkeitstermin für "%1$s" in der Produktion "%2$s" ist <span class="yellow">außer Plan</span>';
$lang["PRODUCTION_WIDGET_ALERT_MILESTONE"] 	= 	'Der Meilenstein Fälligkeitstermin für "%1$s" in der Produktion "%2$s" ist <span class="yellow">außer Plan</span>';

$lang["PRODUCTION_WIDGET_TITLE_PRODUCTION"]		=	'Produktion';
$lang["PRODUCTION_WIDGET_INVITATION_ADMIN"]	=	'Sie wurden als <span class="yellow">Administrator</span> für die Produktion "%1$s" freigeschalten';
$lang["PRODUCTION_WIDGET_INVITATION_GUEST"]	=	'Sie wurden als <span class="yellow">Beobachter</span> für die Produktion "%1$s" freigeschalten';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>