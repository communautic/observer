<?php
// Module name
$productions_phases_name = "Phasen";

// Right
$lang["PRODUCTION_PHASE_TITLE"] = 'Phase';
$lang["PRODUCTION_PHASES"] = 'Phasen';

$lang["PRODUCTION_PHASE_NEW"] = 'Neue Phase';
$lang["PRODUCTION_PHASE_ACTION_NEW"] = 'neue Phase anlegen';
$lang["PRODUCTION_PHASE_TASK_NEW"] = 'Neues Arbeitspaket';
$lang["PRODUCTION_PHASE_MILESTONE_NEW"] = 'Neuer Meilenstein';

$lang["PRODUCTION_PHASE_TEAM"] = 'Mitarbeiter';
$lang["PRODUCTION_PHASE_TASK_MILESTONE"] = 'Arbeitspaket/Meilenstein';
$lang["PRODUCTION_PHASE_TASK"] = 'Arbeitspaket';
$lang["PRODUCTION_PHASE_MILESTONE"] = 'Meilenstein';
$lang["PRODUCTION_PHASE_MILESTONE_DATE"] = 'Zeitpunkt';

$lang["PRODUCTION_PHASE_TASK_START"] = 'Start';
$lang["PRODUCTION_PHASE_TASK_END"] = 'Ende';
$lang["PRODUCTION_PHASE_TASK_TEAM"] = 'Verantwortung';
$lang["PRODUCTION_PHASE_TASK_DEPENDENT"] = 'abhängig';
$lang["PRODUCTION_PHASE_TASK_DEPENDENT_NO"] = 'keine Abhängigkeit';

$lang["PRODUCTION_PHASE_TASK_STATUS_FINISHED"] = 'erreicht am';

$lang["PRODUCTION_PHASE_HELP"] = 'manual_projekte_phasen.pdf';

$lang["PRODUCTION_PRINT_PHASE"] = 'phase.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/phases/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>