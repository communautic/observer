<?php
$brainstorms_rosters_name = "Projektraster";

$lang["BRAINSTORM_ROSTER_TITLE"] = 'Projektraster';
$lang["BRAINSTORM_ROSTERS"] = 'Projektraster';

$lang["BRAINSTORM_ROSTER_NEW"] = 'Neues Projektraster';
$lang["BRAINSTORM_ROSTER_ACTION_NEW"] = 'neues Projektraster anlegen';
$lang["BRAINSTORM_ROSTER_COLUMN_NEW"] = 'PSP Spalten';
$lang["BRAINSTORM_ROSTER_ITEM_NEW"] = 'Neue Idee';
$lang['BRAINSTORM_ROSTER_NOTES'] = 'Ideen';

$lang["BRAINSTORM_ROSTER_COLUMNS_BIN"] = 'Projektraster/Spalten';
$lang["BRAINSTORM_ROSTER_NOTES_BIN"] = 'Projektraster/Ideen';
$lang["BRAINSTORM_PHASE_TITLE"] = 'Phase';

$lang["BRAINSTORM_ROSTER_HELP"] = 'manual_prozesse_projektraster.pdf';

$lang["BRAINSTORM_PRINT_ROSTER"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/rosters/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>