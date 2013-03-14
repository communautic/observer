<?php
// App name
$forums_name = "Forums";
$lang["forums_name"] = 'Forums';

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

$lang["FORUM_POSTS"] = 'Forums / Answers';

$lang["FORUM_HELP"] = 'manual_foren_foren.pdf';
$lang["FORUM_FOLDER_HELP"] = 'manual_foren_ordner.pdf';

// Print images
$lang["PRINT_FORUM"] = 'forum.png';
$lang["PRINT_FORUM_FOLDER"] = 'folder.png';

// Dektop Widget
$lang["FORUM_WIDGET_NO_ACTIVITY"]		=	'Currently there are no notices';
$lang["FORUM_WIDGET_TITLE_BRAINSTORM"]		=	'Forums';
$lang["FORUM_WIDGET_INVITATION_ADMIN"]	=	'You have been added as <span class="yellow">Administrator</span> to the forum "%1$s"';
$lang["FORUM_WIDGET_INVITATION_GUEST"]	=	'You have been added as <span class="yellow">Guest</span> to the forum "%1$s"';

$lang["FORUM_WIDGET_NEW_POST"]				=	'Forum activity';
$lang["FROUM_WIDGET_REMINDER_NEW_POST"]		=	'New posts to the question "%1$s"';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>