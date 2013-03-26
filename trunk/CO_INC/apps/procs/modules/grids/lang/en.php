<?php
$procs_grids_name = "Grids";

$lang["PROC_GRID_TITLE"] = 'Grid';
$lang["PROC_GRIDS"] = 'Grids';

$lang["PROC_GRID_NEW"] = 'New Grid';
$lang["PROC_GRID_ACTION_NEW"] = 'new Grid';

$lang["PROC_GRID_TIME"] = 'Duration';
$lang["PROC_GRID_OWNER"] = 'Owner';
$lang["PROC_GRID_MANAGEMENT"] = 'Manager';
$lang["PROC_GRID_TEAM"] = 'Team';

$lang["PROC_GRID_COLUMN_NEW"] = 'Columns';
$lang["PROC_GRID_TITLE_MAIN"] = 'Main Stage';
$lang["PROC_GRID_TITLE_NEW"] = 'Neuer main stage';
$lang["PROC_GRID_ITEM_NEW"] = 'New Item';
$lang["PROC_GRID_STAGEGATE_NEW"] = 'New Stagegate';
$lang['PROC_GRID_NOTES'] = 'Ideas';

$lang["PROC_GRID_COLUMNS_BIN"] = 'Grid/Columns';
$lang["PROC_GRID_NOTES_BIN"] = 'Grid/Notes';
$lang["PROC_PHASE_TITLE"] = 'Phase';

$lang["PROC_GRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["PROC_PRINT_GRID"] = 'grid.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/grids/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>