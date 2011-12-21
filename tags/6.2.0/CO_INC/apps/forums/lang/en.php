<?php
// App name
$forums_name = "Forums";

// Left
$lang["FORUM_FOLDER"] = 'Folder';
$lang["FORUM_FOLDER_NEW"] = 'New Folder';
$lang["FORUM_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["FORUM_FORUMS"] = 'Forums';
$lang["FORUM_NEW"] = 'New Forum';
$lang["FORUM_ACTION_NEW"] = 'new Forum';

// Folder Right
$lang["FORUM_CREATED_USER"] = 'Initiated by:';

// Forum Right
$lang["FORUM_TITLE"] = 'Forum';

$lang["FORUM_QUESTION"] = 'Question';
$lang["FORUM_ANSWERS"] = 'Answer';
$lang["FORUM_DISCUSSION"] = 'Discussion';

$lang["FORUM_STATUS_PLANNED"] = 'planned';
$lang["FORUM_STATUS_INPROGRESS"] = 'in discussion since';
$lang["FORUM_STATUS_FINISHED"] = 'completed';
$lang["FORUM_STATUS_STOPPED"] = 'stopped';

$lang["FORUM_POSTS"] = 'Forums / Answers';

$lang["FORUM_HELP"] = 'manual_foren_foren.pdf';
$lang["FORUM_FOLDER_HELP"] = 'manual_foren_ordner.pdf';

// Print images
$lang["PRINT_FORUM"] = 'forum.png';
$lang["PRINT_FORUM_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>