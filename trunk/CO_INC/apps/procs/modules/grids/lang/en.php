<?php
$procs_grids_name = "Workplan Templates";

$lang["PROC_GRID_TITLE"] = 'Workplan Template';
$lang["PROC_GRIDS"] = 'Workplan Templates';

$lang["PROC_GRID_NEW"] = 'New Workplan Template';
$lang["PROC_GRID_ACTION_NEW"] = 'new Workplan Template';

$lang["PROC_GRID_PRINTOPTION_GRID"] = 'Grid';
$lang["PROC_GRID_PRINTOPTION_LIST"] = 'Checklist with text';

$lang["PROC_GRID_TIME"] = 'Duration';
$lang["PROC_GRID_COSTS"] = 'Costs';
$lang["PROC_GRID_OWNER"] = 'Owner';
$lang["PROC_GRID_MANAGEMENT"] = 'Manager';
$lang["PROC_GRID_TEAM"] = 'Team';

$lang["PROC_GRID_COLUMN_NEW"] = 'Columns';
$lang["PROC_GRID_TITLE_MAIN"] = 'Main Stage';
$lang["PROC_GRID_TITLE_NEW"] = 'Neuer main stage';
$lang["PROC_GRID_ITEM_NEW"] = 'New Item';
$lang["PROC_GRID_STAGEGATE_NEW"] = 'New Stagegate';
$lang['PROC_GRID_NOTES'] = 'Ideas';

$lang['PROC_GRID_DURATION'] = 'Duration';
$lang['PROC_GRID_HOURS'] = 'hour/s';
$lang['PROC_GRID_COSTS_EMPLOYEES'] = 'Costs Employees';
$lang['PROC_GRID_COSTS_MATERIAL'] = 'Costs Materials';
$lang['PROC_GRID_COSTS_EXTERNAL'] = 'External Costs';
$lang['PROC_GRID_COSTS_OTHER'] = 'Other Costs';

$lang["PROC_GRID_COLUMNS_BIN"] = 'Grid/Columns';
$lang["PROC_GRID_NOTES_BIN"] = 'Grid/Notes';
$lang["PROC_PHASE_TITLE"] = 'Phase';

$lang["PROC_GRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["PROC_PRINT_GRID"] = 'workplan_template.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/grids/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>