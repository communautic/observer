<?php
// Module name
$projects_phases_name = "Phasen";

// Right
$lang["PROJECT_PHASE_TITLE"] = 'Phase';
$lang["PROJECT_PHASES"] = 'Phasen';

$lang["PROJECT_PHASE_NEW"] = 'Neue Phase';
$lang["PROJECT_PHASE_TASK_NEW"] = 'Neues Arbeitspaket';
$lang["PROJECT_PHASE_MILESTONE_NEW"] = 'Neuer Meilenstein';

$lang["PROJECT_PHASE_TEAM"] = 'Mitarbeiter';
$lang["PROJECT_PHASE_TASK_MILESTONE"] = 'Arbeitspaket/Meilenstein';
$lang["PROJECT_PHASE_TASK"] = 'Arbeitspaket';
$lang["PROJECT_PHASE_MILESTONE"] = 'Meilenstein';
$lang["PROJECT_PHASE_MILESTONE_DATE"] = 'Zeitpunkt';

$lang["PROJECT_PHASE_TASK_START"] = 'Start';
$lang["PROJECT_PHASE_TASK_END"] = 'Ende';
$lang["PROJECT_PHASE_TASK_TEAM"] = 'Verantwortung';
$lang["PROJECT_PHASE_TASK_DEPENDENT"] = 'abhängig';

$lang["PROJECT_PHASE_TASK_STATUS_FINISHED"] = 'erreicht am';

$lang["PROJECT_PRINT_PHASE"] = 'phase.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/phases/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>