<?php
$complaints_grids_name = "Prozessraster";

$lang["COMPLAINT_GRID_TITLE"] = 'Prozessraster';
$lang["COMPLAINT_GRIDS"] = 'Prozessraster';

$lang["COMPLAINT_GRID_NEW"] = 'Neues Prozessraster';
$lang["COMPLAINT_GRID_ACTION_NEW"] = 'neues Prozessraster anlegen';

$lang["COMPLAINT_GRID_OWNER"] = 'Prozesseigner';
$lang["COMPLAINT_GRID_MANAGEMENT"] = 'Prozessverantwortung';
$lang["COMPLAINT_GRID_TEAM"] = 'Prozessteam';

$lang["COMPLAINT_GRID_COLUMN_NEW"] = 'Ablaufdiagramm';
$lang["COMPLAINT_GRID_STATUS_PLANED"] = "in Planung";
$lang["COMPLAINT_GRID_STATUS_INPROGRESS"] = "in Arbeit";
$lang["COMPLAINT_GRID_STATUS_FINISHED"] = "abgeschlossen";

$lang["COMPLAINT_GRID_TITLE_MAIN"] = 'Hauptprozess';

$lang["COMPLAINT_GRID_TITLE_NEW"] = 'Neuer Hauptprozess';
$lang["COMPLAINT_GRID_ITEM_NEW"] = 'Neue Tätigkeit';
$lang["COMPLAINT_GRID_STAGEGATE_NEW"] = 'Neues Stagegate';
$lang['COMPLAINT_GRID_NOTES'] = 'Tätigkeiten';

$lang["COMPLAINT_GRID_COLUMNS_BIN"] = 'Prozessraster/Spalten';
$lang["COMPLAINT_GRID_NOTES_BIN"] = 'Prozessraster/Tätigkeiten';
$lang["COMPLAINT_PHASE_TITLE"] = 'Phase';

$lang["COMPLAINT_GRID_HELP"] = 'manual_prozesse_prozessraster.pdf';

$lang["COMPLAINT_PRINT_GRID"] = 'besprechung.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/grids/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>