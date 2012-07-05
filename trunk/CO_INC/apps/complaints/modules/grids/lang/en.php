<?php
$complaints_grids_name = "Grids";

$lang["COMPLAINT_GRID_TITLE"] = 'Grid';
$lang["COMPLAINT_GRIDS"] = 'Grids';

$lang["COMPLAINT_GRID_NEW"] = 'New Grid';
$lang["COMPLAINT_GRID_ACTION_NEW"] = 'new Grid';

$lang["COMPLAINT_GRID_TIME"] = 'Duration';
$lang["COMPLAINT_GRID_OWNER"] = 'Owner';
$lang["COMPLAINT_GRID_MANAGEMENT"] = 'Manager';
$lang["COMPLAINT_GRID_TEAM"] = 'Team';

$lang["COMPLAINT_GRID_COLUMN_NEW"] = 'Columns';
$lang["COMPLAINT_GRID_STATUS_PLANED"] = "planned";
$lang["COMPLAINT_GRID_STATUS_INPROGRESS"] = "in progress";
$lang["COMPLAINT_GRID_STATUS_FINISHED"] = "completed";

$lang["COMPLAINT_GRID_TITLE_MAIN"] = 'Main Stage';

$lang["COMPLAINT_GRID_TITLE_NEW"] = 'Neuer main stage';
$lang["COMPLAINT_GRID_ITEM_NEW"] = 'New Item';
$lang["COMPLAINT_GRID_STAGEGATE_NEW"] = 'New Stagegate';
$lang['COMPLAINT_GRID_NOTES'] = 'Ideas';

$lang["COMPLAINT_GRID_COLUMNS_BIN"] = 'Grid/Columns';
$lang["COMPLAINT_GRID_NOTES_BIN"] = 'Grid/Notes';
$lang["COMPLAINT_PHASE_TITLE"] = 'Phase';

$lang["COMPLAINT_GRID_HELP"] = 'manual_reklamationen_prozessraster.pdf';

$lang["COMPLAINT_PRINT_GRID"] = 'grid.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/grids/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>