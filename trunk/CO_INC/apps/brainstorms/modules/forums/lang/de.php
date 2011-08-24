<?php
// Module name
$brainstorms_forums_name = "Foren";

// Right
$lang["BRAINSTORM_FORUM_TITLE"] = 'Forum';
$lang["BRAINSTORM_FORUMS"] = 'Foren';

$lang["BRAINSTORM_FORUM_NEW"] = 'Neues Forum';
$lang["BRAINSTORM_FORUM_ACTION_NEW"] = 'neues Forum anlegen';
$lang["BRAINSTORM_FORUM_QUESTION"] = 'Frage';


$lang["BRAINSTORM_FORUM_TASK_NEW"] = 'Neues Arbeitspaket';
$lang["BRAINSTORM_FORUM_MILESTONE_NEW"] = 'Neuer Meilenstein';

$lang["BRAINSTORM_FORUM_TEAM"] = 'Mitarbeiter';
$lang["BRAINSTORM_FORUM_TASK_MILESTONE"] = 'Arbeitspaket/Meilenstein';
$lang["BRAINSTORM_FORUM_TASK"] = 'Arbeitspaket';
$lang["BRAINSTORM_FORUM_MILESTONE"] = 'Meilenstein';
$lang["BRAINSTORM_FORUM_MILESTONE_DATE"] = 'Zeitpunkt';

$lang["BRAINSTORM_FORUM_TASK_START"] = 'Start';
$lang["BRAINSTORM_FORUM_TASK_END"] = 'Ende';
$lang["BRAINSTORM_FORUM_TASK_TEAM"] = 'Verantwortung';
$lang["BRAINSTORM_FORUM_TASK_DEPENDENT"] = 'abhängig';
$lang["BRAINSTORM_FORUM_TASK_DEPENDENT_NO"] = 'keine Abhängigkeit';

$lang["BRAINSTORM_FORUM_TASK_STATUS_FINISHED"] = 'erreicht am';

$lang["BRAINSTORM_PRINT_FORUM"] = 'forum.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/forums/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>