<?php
// App name
$forums_name = "Foren";

// Left
$lang["FORUM_FOLDER"] = 'Ordner';
$lang["FORUM_FOLDER_NEW"] = 'Neuer Ordner';
$lang["FORUM_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["FORUM_FORUMS"] = 'Foren';
$lang["FORUM_NEW"] = 'Neues Forum';
$lang["FORUM_ACTION_NEW"] = 'neues Forum anlegen';

// Folder Right
$lang["FORUM_CREATED_USER"] = 'Initiative:';

// Forum Right
$lang["FORUM_TITLE"] = 'Forum';

$lang["FORUM_QUESTION"] = 'Frage';
$lang["FORUM_ANSWERS"] = 'Antwort';
$lang["FORUM_DISCUSSION"] = 'Diskussion';

$lang["FORUM_STATUS_PLANNED"] = 'in Planung seit';
$lang["FORUM_STATUS_INPROGRESS"] = 'in Diskussion seit';
$lang["FORUM_STATUS_FINISHED"] = 'abgeschlossen am';
$lang["FORUM_STATUS_STOPPED"] = 'abgebrochen am';

$lang["FORUM_POSTS"] = 'Foren / Antworten';

$lang["FORUM_HELP"] = 'manual_foren_foren.pdf';
$lang["FORUM_FOLDER_HELP"] = 'manual_foren_ordner.pdf';

// Print images
$lang["PRINT_FORUM"] = 'forum.png';
$lang["PRINT_FORUM_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>