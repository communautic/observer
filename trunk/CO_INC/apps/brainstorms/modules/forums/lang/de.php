<?php
// Module name
$brainstorms_forums_name = "Foren";

// Right
$lang["BRAINSTORM_FORUM_TITLE"] = 'Forum';
$lang["BRAINSTORM_FORUMS"] = 'Foren';

$lang["BRAINSTORM_FORUM_NEW"] = 'Neues Forum';
$lang["BRAINSTORM_FORUM_ACTION_NEW"] = 'neues Forum anlegen';
$lang["BRAINSTORM_FORUM_QUESTION"] = 'Frage';
$lang["BRAINSTORM_FORUM_ANSWERS"] = 'Antwort';
$lang["BRAINSTORM_FORUM_DISCUSSION"] = 'Diskussion';

$lang["BRAINSTORM_FORUM_STATUS_PLANNED"] = 'in Planung seit';
$lang["BRAINSTORM_FORUM_STATUS_INPROGRESS"] = 'in Diskussion seit';
$lang["BRAINSTORM_FORUM_STATUS_FINISHED"] = 'abgeschlossen am';
$lang["BRAINSTORM_FORUM_STATUS_STOPPED"] = 'abgebrochen am';

$lang["BRAINSTORM_FORUM_POSTS"] = 'Foren / Antworten';

$lang["BRAINSTORM_PRINT_FORUM"] = 'forum.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/forums/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>