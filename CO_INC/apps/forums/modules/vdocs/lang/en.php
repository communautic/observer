<?php
$forums_vdocs_name = "Documents";

$lang["FORUM_VDOC_TITLE"] = 'Document';
$lang["FORUM_VDOC_VDOCS"] = 'Documents';
$lang["FORUM_VDOC_NEW"] = 'New Document';
$lang["FORUM_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["FORUM_VDOC_HELP"] = 'manual_foren_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>