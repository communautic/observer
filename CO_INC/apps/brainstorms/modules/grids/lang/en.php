<?php
$brainstorms_grids_name = "Grids";

$lang["BRAINSTORM_GRID_TITLE"] = 'Grid';
$lang["BRAINSTORM_GRIDS"] = 'Grids';

$lang["BRAINSTORM_GRID_NEW"] = 'New Grid';
$lang["BRAINSTORM_GRID_ACTION_NEW"] = 'new Grid';

$lang["BRAINSTORM_GRID_OWNER"] = 'Owner';
$lang["BRAINSTORM_GRID_MANAGEMENT"] = 'Manager';
$lang["BRAINSTORM_GRID_TEAM"] = 'Team';

$lang["BRAINSTORM_GRID_COLUMN_NEW"] = 'Columns';
$lang["BRAINSTORM_GRID_STATUS_PLANED"] = "planned";
$lang["BRAINSTORM_GRID_STATUS_INPROGRESS"] = "in progress";
$lang["BRAINSTORM_GRID_STATUS_FINISHED"] = "completed";

$lang["BRAINSTORM_GRID_TITLE_MAIN"] = 'Main Stage';

$lang["BRAINSTORM_GRID_TITLE_NEW"] = 'Neuer main stage';
$lang["BRAINSTORM_GRID_ITEM_NEW"] = 'New Item';
$lang["BRAINSTORM_GRID_STAGEGATE_NEW"] = 'New Stagegate';
$lang['BRAINSTORM_GRID_NOTES'] = 'Ideas';

$lang["BRAINSTORM_GRID_COLUMNS_BIN"] = 'Grid/Columns';
$lang["BRAINSTORM_GRID_NOTES_BIN"] = 'Grid/Notes';
$lang["BRAINSTORM_PHASE_TITLE"] = 'Phase';

$lang["BRAINSTORM_GRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["BRAINSTORM_PRINT_GRID"] = 'grid.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/grids/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>