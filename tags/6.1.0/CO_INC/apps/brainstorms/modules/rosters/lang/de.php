<?php
$brainstorms_rosters_name = "Projektraster";

$lang["BRAINSTORM_ROSTER_TITLE"] = 'Projektraster';
$lang["BRAINSTORM_ROSTERS"] = 'Projektraster';

$lang["BRAINSTORM_ROSTER_NEW"] = 'Neues Projektraster';
$lang["BRAINSTORM_ROSTER_ACTION_NEW"] = 'neues Projektraster anlegen';
$lang["BRAINSTORM_ROSTER_COLUMN_NEW"] = 'PSP Spalten';
$lang["BRAINSTORM_ROSTER_ITEM_NEW"] = 'Neue Tätigkeit';
$lang['BRAINSTORM_ROSTER_NOTES'] = 'Tätigkeiten';

$lang["BRAINSTORM_ROSTER_COLUMNS_BIN"] = 'Projektraster/Spalten';
$lang["BRAINSTORM_ROSTER_NOTES_BIN"] = 'Projektraster/Tätigkeiten';

$lang["BRAINSTORM_PRINT_ROSTER"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/rosters/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>