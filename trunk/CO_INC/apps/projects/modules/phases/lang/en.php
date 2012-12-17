<?php
// Module name
$projects_phases_name = "Phases";

// Right
$lang["PROJECT_PHASE_TITLE"] = 'Phase';
$lang["PROJECT_PHASES"] = 'Phases';

$lang["PROJECT_PHASE_NEW"] = 'New Phase';
$lang["PROJECT_PHASE_ACTION_NEW"] = 'new Phase';
$lang["PROJECT_PHASE_TASK_NEW"] = 'New Task';
$lang["PROJECT_PHASE_MILESTONE_NEW"] = 'New Milestone';

$lang["PROJECT_PHASE_TEAM"] = 'Team';
$lang["PROJECT_PHASE_TASK_MILESTONE"] = 'Task/Milestone';
$lang["PROJECT_PHASE_TASK"] = 'Task';
$lang["PROJECT_PHASE_MILESTONE"] = 'Milestone';
$lang["PROJECT_PHASE_MILESTONE_DATE"] = 'Date';
$lang["PROJECT_PHASE_PROJECTLINK"] = 'Project link';

$lang["PROJECT_PHASE_TASK_START"] = 'Start';
$lang["PROJECT_PHASE_TASK_END"] = 'End';
$lang["PROJECT_PHASE_TASK_TEAM"] = 'Responsibility';
$lang["PROJECT_PHASE_TASK_DEPENDENT"] = 'depends';
$lang["PROJECT_PHASE_TASK_DEPENDENT_NO"] = 'not dependend';

$lang["PROJECT_PHASE_TASK_STATUS_FINISHED"] = 'completed by';

$lang["PROJECT_PRINT_PHASE"] = 'phase.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/phases/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>