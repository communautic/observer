<?php
$brainstorms_rosters_name = "Rosters";

$lang["BRAINSTORM_ROSTER_TITLE"] = 'Roster';
$lang["BRAINSTORM_ROSTERS"] = 'Rosters';

$lang["BRAINSTORM_ROSTER_NEW"] = 'New Roster';
$lang["BRAINSTORM_ROSTER_ACTION_NEW"] = 'new Roster';
$lang["BRAINSTORM_ROSTER_TASK_NEW"] = 'New Item';
//define('ROSTER_RELATES_TO', 'bezogen auf');
$lang["BRAINSTORM_ROSTER_DATE"] = 'Date';
$lang["BRAINSTORM_ROSTER_PLACE"] = 'Location';
$lang["BRAINSTORM_ROSTER_TIME_START"] = 'Start';
$lang["BRAINSTORM_ROSTER_TIME_END"] = 'End';

$lang["BRAINSTORM_ROSTER_ATTENDEES"] = 'Attendees';
$lang["BRAINSTORM_ROSTER_MANAGEMENT"] = 'Minuted by';
$lang["BRAINSTORM_ROSTER_GOALS"] = 'Agenda';

$lang["BRAINSTORM_ROSTER_STATUS_PLANNED"] = 'planned';
$lang["BRAINSTORM_ROSTER_STATUS_ON_SCHEDULE"] = 'on schedule';
$lang["BRAINSTORM_ROSTER_STATUS_CANCELLED"] = 'cancelled';
$lang["BRAINSTORM_ROSTER_STATUS_POSPONED"] = 'posponed to';
$lang["BRAINSTORM_ROSTER_POSPONED"] = 'posponed';

$lang["BRAINSTORM_PRINT_ROSTER"] = 'roster.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/rosters/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>