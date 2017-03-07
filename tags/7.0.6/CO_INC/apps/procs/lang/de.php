<?php
// App name
$procs_name = "Prozesse";
$lang["procs_name"] = 'Prozesse';

// Left
$lang["PROC_FOLDER"] = 'Ordner';
$lang["PROC_FOLDER_NEW"] = 'Neuer Ordner';
$lang["PROC_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["PROC_PROCS"] = 'Prozesse';
$lang["PROC_NEW"] = 'Neuer Prozess';
$lang["PROC_ACTION_NEW"] = 'neuen Prozess anlegen';

$lang["PROC_NEW_OPTION_PROCESS"] = 'neuer Prozess';
$lang["PROC_NEW_OPTION_PROCESSLINK"] = 'Prozesslink';

// Folder Right
$lang["PROC_FOLDER_CREATED_ON"] = 'angelegt am';
$lang["PROC_FOLDER_INITIATOR"] = 'Initiative:';

$lang["PROC_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["PROC_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["PROC_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["PROC_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';

// Proc Right
$lang["PROC_TITLE"] = 'Prozess';
$lang['PROC_NOTE_ADD'] = 'Tätigkeiten';
$lang['PROC_NOTE_NEW'] = 'neue Tätigkeit';

$lang["PROC_CLIENT"] = 'Projektauftraggeber';
$lang["PROC_MANAGEMENT"] = 'Projektleitung';
$lang["PROC_TEAM"] = 'Projektteam';
$lang["PROC_DESCRIPTION"] = 'Beschreibung';

// Bin
$lang['PROC_TITLE_NOTES_BIN'] = 'Prozesse/Tätigkeiten';
$lang['PROC_NOTE_BIN'] = 'Tätigkeiten';

$lang["PROC_HANDBOOK"] = 'Projekthandbuch';

$lang["PROC_HELP"] = 'manual_prozesse_prozesse.pdf';
$lang["PROC_FOLDER_HELP"] = 'manual_prozesse_ordner.pdf';

// Print images
$lang["PRINT_PROC_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_PROC"] = 'projekt.png';
$lang["PRINT_PROC_FOLDER"] = 'ordner.png';

// Dektop Widget
$lang["PROC_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["PROC_WIDGET_TITLE_PROC"]		=	'Freischaltung';
$lang["PROC_WIDGET_INVITATION_ADMIN"]	=	'als <span class="yellow">Administrator</span> für "%1$s"';
$lang["PROC_WIDGET_INVITATION_GUEST"]	=	'als <span class="yellow">Beobachter</span> für "%1$s"';

/* Archiv */
$lang["PROC_ARCHIVE"] = 'Prozessarchiv';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>