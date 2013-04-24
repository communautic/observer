<?php
$procs_pspgrids_name = "Pspgrids";

$lang["PROC_PSPGRID_TITLE"] = 'Pspgrid';
$lang["PROC_PSPGRIDS"] = 'Pspgrids';

$lang["PROC_PSPGRID_NEW"] = 'New Pspgrid';
$lang["PROC_PSPGRID_ACTION_NEW"] = 'new Pspgrid';

$lang["PROC_PSPGRID_TIME"] = 'Duration';
$lang["PROC_PSPGRID_OWNER"] = 'Owner';
$lang["PROC_PSPGRID_MANAGEMENT"] = 'Manager';
$lang["PROC_PSPGRID_TEAM"] = 'Team';

$lang["PROC_PSPGRID_COLUMN_NEW"] = 'Columns';
$lang["PROC_PSPGRID_TITLE_MAIN"] = 'Main Stage';
$lang["PROC_PSPGRID_TITLE_NEW"] = 'Neuer main stage';
$lang["PROC_PSPGRID_ITEM_NEW"] = 'New Item';
$lang["PROC_PSPGRID_STAGEGATE_NEW"] = 'New Stagegate';
$lang['PROC_PSPGRID_NOTES'] = 'Ideas';

$lang['PROC_PSPGRID_DURATION'] = 'Guration';
$lang['PROC_PSPGRID_DAYS'] = 'hour/s';
$lang['PROC_PSPGRID_COSTS_EMPLOYEES'] = 'Costs Employees';
$lang['PROC_PSPGRID_COSTS_MATERIAL'] = 'Costs Materials';
$lang['PROC_PSPGRID_COSTS_EXTERNAL'] = 'External Costs';
$lang['PROC_PSPGRID_COSTS_OTHER'] = 'Other Costs';

$lang["PROC_PSPGRID_COLUMNS_BIN"] = 'Pspgrid/Columns';
$lang["PROC_PSPGRID_NOTES_BIN"] = 'Pspgrid/Notes';
$lang["PROC_PHASE_TITLE"] = 'Phase';

$lang["PROC_PSPGRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["PROC_PRINT_PSPGRID"] = 'pspgrid.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/pspgrids/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>