<?php
// Module name
$brainstorms_forums_name = "Forums";

// Right
$lang["BRAINSTORM_FORUM_TITLE"] = 'Forum';
$lang["BRAINSTORM_FORUMS"] = 'Forums';

$lang["BRAINSTORM_FORUM_NEW"] = 'New Forum';
$lang["BRAINSTORM_FORUM_ACTION_NEW"] = 'new Topic';
$lang["BRAINSTORM_FORUM_QUESTION"] = 'Question';
$lang["BRAINSTORM_FORUM_ANSWERS"] = 'Answer';
$lang["BRAINSTORM_FORUM_DISCUSSION"] = 'Discussion';

$lang["BRAINSTORM_FORUM_STATUS_PLANNED"] = 'planned';
$lang["BRAINSTORM_FORUM_STATUS_INPROGRESS"] = 'in discussion';
$lang["BRAINSTORM_FORUM_STATUS_FINISHED"] = 'finished';
$lang["BRAINSTORM_FORUM_STATUS_STOPPED"] = 'stopped';

$lang["BRAINSTORM_FORUM_POSTS"] = 'Forum / Posts';

$lang["BRAINSTORM_FORUM_HELP"] = 'manual_prozesse_foren.pdf';

$lang["BRAINSTORM_PRINT_FORUM"] = 'forum.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/forums/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>