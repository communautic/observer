<?php
// Module name
$phases_name = "Phasen";

// Right
$lang["PHASE_TITLE"] = 'Phase';

$lang["PHASE_NEW"] = 'Neue Phase';
$lang["PHASE_TASK_NEW"] = 'Neues Arbeitspaket';
$lang["PHASE_MILESTONE_NEW"] = 'Neuer Meilenstein';

$lang["PHASE_TEAM"] = 'Mitarbeiter';
$lang["PHASE_TASK_MILESTONE"] = 'Arbeitspaket/Meilenstein';
$lang["PHASE_TASK"] = 'Arbeitspaket';
$lang["PHASE_MILESTONE"] = 'Meilenstein';
$lang["PHASE_MILESTONE_DATE"] = 'Zeitpunkt';

$lang["PHASE_TASK_START"] = 'Start';
$lang["PHASE_TASK_END"] = 'Ende';
$lang["PHASE_TASK_TEAM"] = 'Verantwortung';
$lang["PHASE_TASK_DEPENDENT"] = 'abhängig';

$lang["PHASE_TASK_STATUS_FINISHED"] = 'erreicht am';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/phases/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>