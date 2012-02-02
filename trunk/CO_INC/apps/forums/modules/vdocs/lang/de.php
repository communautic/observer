<?php
$forums_vdocs_name = "Textbeiträge";

$lang["FORUM_VDOC_TITLE"] = 'Textbeitrag';
$lang["FORUM_VDOC_VDOCS"] = 'Textbeiträge';
$lang["FORUM_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["FORUM_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["FORUM_VDOC_HELP"] = 'manual_foren_Textbeittraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>