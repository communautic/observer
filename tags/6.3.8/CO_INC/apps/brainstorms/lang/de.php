<?php
// App name
$brainstorms_name = "Prozesse";
$lang["brainstorms_name"] = 'Prozesse';

// Left
$lang["BRAINSTORM_FOLDER"] = 'Ordner';
$lang["BRAINSTORM_FOLDER_NEW"] = 'Neuer Ordner';
$lang["BRAINSTORM_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["BRAINSTORM_BRAINSTORMS"] = 'Prozesse';
$lang["BRAINSTORM_NEW"] = 'Neuer Prozess';
$lang["BRAINSTORM_ACTION_NEW"] = 'neuen Prozess anlegen';

// Folder Right
$lang["BRAINSTORM_FOLDER_CREATED_ON"] = 'angelegt am';
$lang["BRAINSTORM_FOLDER_INITIATOR"] = 'Initiative:';

$lang["BRAINSTORM_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["BRAINSTORM_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["BRAINSTORM_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["BRAINSTORM_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';

// Brainstorm Right
$lang["BRAINSTORM_TITLE"] = 'Prozess';
$lang['BRAINSTORM_NOTE_ADD'] = 'Tätigkeiten';
$lang['BRAINSTORM_NOTE_NEW'] = 'neue Tätigkeit';

$lang["BRAINSTORM_CLIENT"] = 'Projektauftraggeber';
$lang["BRAINSTORM_MANAGEMENT"] = 'Projektleitung';
$lang["BRAINSTORM_TEAM"] = 'Projektteam';
$lang["BRAINSTORM_DESCRIPTION"] = 'Beschreibung';

// Bin
$lang['BRAINSTORM_TITLE_NOTES_BIN'] = 'Prozesse/Tätigkeiten';
$lang['BRAINSTORM_NOTE_BIN'] = 'Tätigkeiten';

$lang["BRAINSTORM_HANDBOOK"] = 'Projekthandbuch';

$lang["BRAINSTORM_HELP"] = 'manual_prozesse_prozesse.pdf';
$lang["BRAINSTORM_FOLDER_HELP"] = 'manual_prozesse_ordner.pdf';

// Print images
$lang["PRINT_BRAINSTORM_MANUAL"] = 'projekthandbuch.png';
$lang["PRINT_BRAINSTORM"] = 'projekt.png';
$lang["PRINT_BRAINSTORM_FOLDER"] = 'ordner.png';

// Dektop Widget
$lang["BRAINSTORM_WIDGET_NO_ACTIVITY"]		=	'Keine aktuellen Benachrichtigungen';
$lang["BRAINSTORM_WIDGET_TITLE_BRAINSTORM"]		=	'Freischaltung';
$lang["BRAINSTORM_WIDGET_INVITATION_ADMIN"]	=	'als <span class="yellow">Administrator</span> für "%1$s"';
$lang["BRAINSTORM_WIDGET_INVITATION_GUEST"]	=	'als <span class="yellow">Beobachter</span> für "%1$s"';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>