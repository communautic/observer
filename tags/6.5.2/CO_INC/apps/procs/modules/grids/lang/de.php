<?php
$procs_grids_name = "Prozessraster";

$lang["PROC_GRID_TITLE"] = 'Prozessraster';
$lang["PROC_GRIDS"] = 'Prozessraster';

$lang["PROC_GRID_NEW"] = 'Neues Prozessraster';
$lang["PROC_GRID_ACTION_NEW"] = 'neues Prozessraster anlegen';

$lang["PROC_GRID_TIME"] = 'Durchlaufzeit';
$lang["PROC_GRID_COSTS"] = 'Prozesskosten';
$lang["PROC_GRID_OWNER"] = 'Prozesseigner';
$lang["PROC_GRID_MANAGEMENT"] = 'Prozessverantwortung';
$lang["PROC_GRID_TEAM"] = 'Prozessteam';

$lang["PROC_GRID_COLUMN_NEW"] = 'Hauptprozess';
$lang["PROC_GRID_TITLE_MAIN"] = 'Hauptprozess';
$lang["PROC_GRID_TITLE_NEW"] = 'Neuer Hauptprozess';
$lang["PROC_GRID_ITEM_NEW"] = 'Neue Tätigkeit';
$lang["PROC_GRID_STAGEGATE_NEW"] = 'Neues Stagegate';
$lang['PROC_GRID_NOTES'] = 'Tätigkeiten';

$lang['PROC_GRID_DURATION'] = 'Dauer';
$lang['PROC_GRID_HOURS'] = 'Stunde(n)';
$lang['PROC_GRID_COSTS_EMPLOYEES'] = 'Personalkosten';
$lang['PROC_GRID_COSTS_MATERIAL'] = 'Materialkosten';
$lang['PROC_GRID_COSTS_EXTERNAL'] = 'Fremdleistungen';
$lang['PROC_GRID_COSTS_OTHER'] = 'Sonstige Kosten';

$lang["PROC_GRID_COLUMNS_BIN"] = 'Prozessraster/Spalten';
$lang["PROC_GRID_NOTES_BIN"] = 'Prozessraster/Tätigkeiten';
$lang["PROC_PHASE_TITLE"] = 'Phase';

$lang["PROC_GRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["PROC_PRINT_GRID"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/grids/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>