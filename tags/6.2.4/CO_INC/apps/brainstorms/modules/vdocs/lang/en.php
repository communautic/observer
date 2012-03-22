<?php
$brainstorms_vdocs_name = "VDocs";

$lang["BRAINSTORM_VDOC_TITLE"] = 'VDoc';
$lang["BRAINSTORM_VDOC_NEW"] = 'New VDoc';
$lang["BRAINSTORM_VDOC_TASK_NEW"] = 'New Topic';
$lang["BRAINSTORM_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["BRAINSTORM_VDOC_HELP"] = 'manual_prozesse_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>