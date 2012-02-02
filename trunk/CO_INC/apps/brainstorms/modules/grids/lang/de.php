<?php
$brainstorms_grids_name = "Projektraster";

$lang["BRAINSTORM_GRID_TITLE"] = 'Projektraster';
$lang["BRAINSTORM_GRIDS"] = 'Projektraster';

$lang["BRAINSTORM_GRID_NEW"] = 'Neues Projektraster';
$lang["BRAINSTORM_GRID_ACTION_NEW"] = 'neues Projektraster anlegen';
$lang["BRAINSTORM_GRID_COLUMN_NEW"] = 'PSP Spalten';
$lang["BRAINSTORM_GRID_ITEM_NEW"] = 'Neue Tätigkeit';
$lang['BRAINSTORM_GRID_NOTES'] = 'Tätigkeiten';

$lang["BRAINSTORM_GRID_COLUMNS_BIN"] = 'Projektraster/Spalten';
$lang["BRAINSTORM_GRID_NOTES_BIN"] = 'Projektraster/Tätigkeiten';
$lang["BRAINSTORM_PHASE_TITLE"] = 'Phase';

$lang["BRAINSTORM_GRID_HELP"] = 'manual_prozesse_projektraster.pdf';

$lang["BRAINSTORM_PRINT_GRID"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/grids/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>