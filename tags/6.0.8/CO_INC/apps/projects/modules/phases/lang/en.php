<?php
// Module name
$phases_name = "Phases";

// Right
$lang["PHASE_TITLE"] = 'Phase';

$lang["PHASE_NEW"] = 'New Phase';
$lang["PHASE_TASK_NEW"] = 'New Stage';
$lang["PHASE_MILESTONE_NEW"] = 'New Milestone';

$lang["PHASE_TEAM"] = 'Team';
$lang["PHASE_TASK_MILESTONE"] = 'Stage/Milestone';
$lang["PHASE_TASK"] = 'Stage';
$lang["PHASE_MILESTONE"] = 'Milestone';
$lang["PHASE_MILESTONE_DATE"] = 'Date';

$lang["PHASE_TASK_START"] = 'Start';
$lang["PHASE_TASK_END"] = 'End';
$lang["PHASE_TASK_TEAM"] = 'Responsibility';
$lang["PHASE_TASK_DEPENDENT"] = 'depends';

$lang["PHASE_TASK_STATUS_FINISHED"] = 'completed by';

$lang["PRINT_PHASE"] = 'phase.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/phases/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>