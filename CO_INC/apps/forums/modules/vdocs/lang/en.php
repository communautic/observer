<?php
$forums_vdocs_name = "VDocs";

$lang["FORUM_VDOC_TITLE"] = 'VDoc';
$lang["FORUM_VDOC_NEW"] = 'New VDoc';
$lang["FORUM_VDOC_TASK_NEW"] = 'New Topic';
$lang["FORUM_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["FORUM_VDOC_HELP"] = 'manual_foren_Textbeittraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>