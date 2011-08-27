<?php
$brainstorms_rosters_name = "Rosters";

$lang["BRAINSTORM_ROSTER_TITLE"] = 'Roster';
$lang["BRAINSTORM_ROSTERS"] = 'Rosters';

$lang["BRAINSTORM_ROSTER_NEW"] = 'New Roster';
$lang["BRAINSTORM_ROSTER_ACTION_NEW"] = 'new Roster';
$lang["BRAINSTORM_ROSTER_COLUMN_NEW"] = 'Columns';
$lang["BRAINSTORM_ROSTER_TASK_NEW"] = 'New Item';
$lang['BRAINSTORM_ROSTER_NOTES'] = 'Tätigkeiten';

$lang["BRAINSTORM_ROSTER_COLUMNS_BIN"] = 'Roster/Columns';
$lang["BRAINSTORM_ROSTER_NOTES_BIN"] = 'Roster/Notes';

$lang["BRAINSTORM_PRINT_ROSTER"] = 'roster.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/rosters/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>