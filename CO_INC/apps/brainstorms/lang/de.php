<?php
// App name
$brainstorms_name = "Prozesse";

// Left
$lang["BRAINSTORM_FOLDER"] = 'Ordner';
$lang["BRAINSTORM_FOLDER_NEW"] = 'Neuer Ordner';
$lang["BRAINSTORM_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["BRAINSTORM_BRAINSTORMS"] = 'Prozesse';
$lang["BRAINSTORM_NEW"] = 'Neuer Prozess';
$lang["BRAINSTORM_ACTION_NEW"] = 'neuen Prozess anlegen';

// Folder Right
$lang["BRAINSTORM_FOLDER_CREATED_ON"] = 'angelegt am';
$lang["BRAINSTORM_FOLDER_INITIATOR"] = 'Initiator:';

/*$lang["BRAINSTORM_FOLDER_BRAINSTORMS_CREATED"] = 'Prozesse insgesamt';
$lang["BRAINSTORM_FOLDER_BRAINSTORMS_PLANNED"] = 'Prozesse in Planung';
$lang["BRAINSTORM_FOLDER_BRAINSTORMS_RUNNING"] = 'Prozesse in Arbeit';
$lang["BRAINSTORM_FOLDER_BRAINSTORMS_FINISHED"] = 'Prozesse abgeschlossen';
$lang["BRAINSTORM_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["BRAINSTORM_FOLDER_STATUS_ARCHIVE"] = 'archiv';*/

$lang["BRAINSTORM_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["BRAINSTORM_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["BRAINSTORM_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["BRAINSTORM_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';

// Brainstorm Right
$lang["BRAINSTORM_TITLE"] = 'Prozess';
$lang['BRAINSTORM_NOTE_ADD'] = 'Ideen';
$lang['BRAINSTORM_NOTE_NEW'] = 'neue Idee';

$lang["BRAINSTORM_CLIENT"] = 'Projektauftraggeber';
$lang["BRAINSTORM_MANAGEMENT"] = 'Projektleitung';
$lang["BRAINSTORM_TEAM"] = 'Projektteam';
$lang["BRAINSTORM_DESCRIPTION"] = 'Beschreibung';

$lang["BRAINSTORM_STATUS_PLANNED"] = 'in Planung seit';
$lang["BRAINSTORM_STATUS_INPROGRESS"] = 'in Arbeit seit';
$lang["BRAINSTORM_STATUS_FINISHED"] = 'abgeschlossen am';
$lang["BRAINSTORM_STATUS_STOPPED"] = 'abgebrochen am';

// Bin
$lang['BRAINSTORM_TITLE_NOTES_BIN'] = 'Prozesse/Ideen';
$lang['BRAINSTORM_NOTE_BIN'] = 'Ideen';

$lang["BRAINSTORM_HANDBOOK"] = 'Projekthandbuch';

$lang["BRAINSTORM_HELP"] = 'manual_prozesse_prozesse.pdf';
$lang["BRAINSTORM_FOLDER_HELP"] = 'manual_prozesse_ordner.pdf';

// Print images
$lang["PRINT_BRAINSTORM_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_BRAINSTORM"] = 'projekt.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>