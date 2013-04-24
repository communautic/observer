<?php
$procs_pspgrids_name = "Projektraster";

$lang["PROC_PSPGRID_TITLE"] = 'Projektraster';
$lang["PROC_PSPGRIDS"] = 'Projektraster';

$lang["PROC_PSPGRID_NEW"] = 'Neues Projektraster';
$lang["PROC_PSPGRID_ACTION_NEW"] = 'neues Projektraster anlegen';

$lang["PROC_PSPGRID_TIME"] = 'Projektdauer';
$lang["PROC_PSPGRID_COSTS"] = 'Projektkosten';
$lang["PROC_PSPGRID_OWNER"] = 'Projekteigner';
$lang["PROC_PSPGRID_MANAGEMENT"] = 'Projektverantwortung';
$lang["PROC_PSPGRID_TEAM"] = 'Projektteam';

$lang["PROC_PSPGRID_COLUMN_NEW"] = 'Ablaufdiagramm';
$lang["PROC_PSPGRID_TITLE_MAIN"] = 'Hauptprozess';
$lang["PROC_PSPGRID_TITLE_NEW"] = 'Neue Phase';
$lang["PROC_PSPGRID_ITEM_NEW"] = 'Neues Arbeitspaket';
$lang["PROC_PSPGRID_STAGEGATE_NEW"] = 'Neues Stagegate';
$lang['PROC_PSPGRID_NOTES'] = 'Tätigkeiten';

$lang['PROC_PSPGRID_DURATION'] = 'Dauer';
$lang['PROC_PSPGRID_DAYS'] = 'Tag/e';
$lang['PROC_PSPGRID_COSTS_EMPLOYEES'] = 'Personalkosten';
$lang['PROC_PSPGRID_COSTS_MATERIAL'] = 'Materialkosten';
$lang['PROC_PSPGRID_COSTS_EXTERNAL'] = 'Fremdleistungen';
$lang['PROC_PSPGRID_COSTS_OTHER'] = 'Sonstige Kosten';

$lang["PROC_PSPGRID_COLUMNS_BIN"] = 'Projektraster/Spalten';
$lang["PROC_PSPGRID_NOTES_BIN"] = 'Projektraster/Tätigkeiten';
$lang["PROC_PHASE_TITLE"] = 'Phase';

$lang["PROC_PSPGRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["PROC_PRINT_PSPGRID"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/pspgrids/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>