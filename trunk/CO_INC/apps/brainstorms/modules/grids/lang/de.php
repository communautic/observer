<?php
$brainstorms_grids_name = "Prozessraster";

$lang["BRAINSTORM_GRID_TITLE"] = 'Prozessraster';
$lang["BRAINSTORM_GRIDS"] = 'Prozessraster';

$lang["BRAINSTORM_GRID_NEW"] = 'Neues Prozessraster';
$lang["BRAINSTORM_GRID_ACTION_NEW"] = 'neues Prozessraster anlegen';

$lang["BRAINSTORM_GRID_OWNER"] = 'Prozesseigner';
$lang["BRAINSTORM_GRID_MANAGEMENT"] = 'Prozessverantwortung';
$lang["BRAINSTORM_GRID_TEAM"] = 'Prozessteam';

$lang["BRAINSTORM_GRID_COLUMN_NEW"] = 'Ablaufdiagramm';
$lang["BRAINSTORM_GRID_STATUS_PLANED"] = "in Planung";
$lang["BRAINSTORM_GRID_STATUS_INPROGRESS"] = "in Arbeit";
$lang["BRAINSTORM_GRID_STATUS_FINISHED"] = "abgeschlossen";

$lang["BRAINSTORM_GRID_TITLE_MAIN"] = 'Hauptprozess';

$lang["BRAINSTORM_GRID_TITLE_NEW"] = 'Neuer Hauptprozess';
$lang["BRAINSTORM_GRID_ITEM_NEW"] = 'Neue Tätigkeit';
$lang["BRAINSTORM_GRID_STAGEGATE_NEW"] = 'Neues Stagegate';
$lang['BRAINSTORM_GRID_NOTES'] = 'Tätigkeiten';

$lang["BRAINSTORM_GRID_COLUMNS_BIN"] = 'Prozessraster/Spalten';
$lang["BRAINSTORM_GRID_NOTES_BIN"] = 'Prozessraster/Tätigkeiten';
$lang["BRAINSTORM_PHASE_TITLE"] = 'Phase';

$lang["BRAINSTORM_GRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["BRAINSTORM_PRINT_GRID"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/grids/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>