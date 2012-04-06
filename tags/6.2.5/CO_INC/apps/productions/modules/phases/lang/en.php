<?php
// Module name
$productions_phases_name = "Phases";

// Right
$lang["PRODUCTION_PHASE_TITLE"] = 'Phase';
$lang["PRODUCTION_PHASES"] = 'Phases';

$lang["PRODUCTION_PHASE_NEW"] = 'New Phase';
$lang["PRODUCTION_PHASE_ACTION_NEW"] = 'new Phase';
$lang["PRODUCTION_PHASE_TASK_NEW"] = 'New Stage';
$lang["PRODUCTION_PHASE_MILESTONE_NEW"] = 'New Milestone';

$lang["PRODUCTION_PHASE_TEAM"] = 'Team';
$lang["PRODUCTION_PHASE_TASK_MILESTONE"] = 'Stage/Milestone';
$lang["PRODUCTION_PHASE_TASK"] = 'Stage';
$lang["PRODUCTION_PHASE_MILESTONE"] = 'Milestone';
$lang["PRODUCTION_PHASE_MILESTONE_DATE"] = 'Date';

$lang["PRODUCTION_PHASE_TASK_START"] = 'Start';
$lang["PRODUCTION_PHASE_TASK_END"] = 'End';
$lang["PRODUCTION_PHASE_TASK_TEAM"] = 'Responsibility';
$lang["PRODUCTION_PHASE_TASK_DEPENDENT"] = 'depends';
$lang["PRODUCTION_PHASE_TASK_DEPENDENT_NO"] = 'not dependend';

$lang["PRODUCTION_PHASE_TASK_STATUS_FINISHED"] = 'completed by';

$lang["PRODUCTION_PRINT_PHASE"] = 'phase.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/phases/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>