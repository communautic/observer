<?php
// App name
$publishers_name = "Webnews";

// Left
$lang["PUBLISHER_FOLDER"] = 'Ordner';
$lang["PUBLISHER_FOLDER_NEW"] = 'Neuer Ordner';
$lang["PUBLISHER_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["PUBLISHER_PUBLISHERS"] = 'Webnews';
$lang["PUBLISHER_NEW"] = 'Neues Projekt';
$lang["PUBLISHER_ACTION_NEW"] = 'neues Projekt anlegen';

// Folder Right
$lang["PUBLISHER_FOLDER_PUBLISHERS_CREATED"] = 'Webnews insgesamt';
$lang["PUBLISHER_FOLDER_PUBLISHERS_PLANNED"] = 'Webnews in Planung';
$lang["PUBLISHER_FOLDER_PUBLISHERS_RUNNING"] = 'Webnews in Arbeit';
$lang["PUBLISHER_FOLDER_PUBLISHERS_FINISHED"] = 'Webnews abgeschlossen';
$lang["PUBLISHER_FOLDER_PUBLISHERS_STOPPED"] = 'Webnews abgebrochen';
$lang["PUBLISHER_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["PUBLISHER_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["PUBLISHER_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["PUBLISHER_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["PUBLISHER_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["PUBLISHER_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["PUBLISHER_FOLDER_CHART_STATUS"] = 'Status';

// Publisher Right
$lang["PUBLISHER_TITLE"] = 'Projekt';
$lang['PUBLISHER_KICKOFF'] = 'Kick Off';

$lang["PUBLISHER_CLIENT"] = 'Projektauftraggeber';
$lang["PUBLISHER_MANAGEMENT"] = 'Projektleitung';
$lang["PUBLISHER_TEAM"] = 'Projektteam';
$lang["PUBLISHER_DESCRIPTION"] = 'Beschreibung';

$lang["PUBLISHER_STATUS_PLANNED"] = 'in Planung seit';
$lang["PUBLISHER_STATUS_INPROGRESS"] = 'in Arbeit seit';
$lang["PUBLISHER_STATUS_FINISHED"] = 'abgeschlossen am';
$lang["PUBLISHER_STATUS_STOPPED"] = 'abgebrochen am';

$lang["PUBLISHER_STATUS_PLANNED_TEXT"] = 'in Planung';
$lang["PUBLISHER_STATUS_INPROGRESS_TEXT"] = 'in Arbeit';
$lang["PUBLISHER_STATUS_FINISHED_TEXT"] = 'abgeschlossen';
$lang["PUBLISHER_STATUS_STOPPED_TEXT"] = 'abgebrochen';

$lang["PUBLISHER_HANDBOOK"] = 'Projekthandbuch';

$lang["PUBLISHER_HELP"] = 'manual_projekte_projekte.pdf';
$lang["PUBLISHER_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_PUBLISHER_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_PUBLISHER"] = 'projekt.png';
$lang["PRINT_PUBLISHER_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/publishers/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>