<?php
// Module name
$brainstorms_forums_name = "Forums";

// Right
$lang["BRAINSTORM_FORUM_TITLE"] = 'Forum';
$lang["BRAINSTORM_FORUMS"] = 'Forums';

$lang["BRAINSTORM_FORUM_NEW"] = 'New Forum';
$lang["BRAINSTORM_FORUM_ACTION_NEW"] = 'new Topic';
$lang["BRAINSTORM_FORUM_TASK_NEW"] = 'New Stage';
$lang["BRAINSTORM_FORUM_MILESTONE_NEW"] = 'New Milestone';

$lang["BRAINSTORM_FORUM_TEAM"] = 'Team';
$lang["BRAINSTORM_FORUM_TASK_MILESTONE"] = 'Stage/Milestone';
$lang["BRAINSTORM_FORUM_TASK"] = 'Stage';
$lang["BRAINSTORM_FORUM_MILESTONE"] = 'Milestone';
$lang["BRAINSTORM_FORUM_MILESTONE_DATE"] = 'Date';

$lang["BRAINSTORM_FORUM_TASK_START"] = 'Start';
$lang["BRAINSTORM_FORUM_TASK_END"] = 'End';
$lang["BRAINSTORM_FORUM_TASK_TEAM"] = 'Responsibility';
$lang["BRAINSTORM_FORUM_TASK_DEPENDENT"] = 'depends';
$lang["BRAINSTORM_FORUM_TASK_DEPENDENT_NO"] = 'not dependend';

$lang["BRAINSTORM_FORUM_TASK_STATUS_FINISHED"] = 'completed by';

$lang["BRAINSTORM_PRINT_FORUM"] = 'forum.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/forums/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>