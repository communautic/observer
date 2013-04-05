<?php
$procs_vdocs_name = "VDocs";

$lang["PROC_VDOC_TITLE"] = 'VDoc';
$lang["PROC_VDOC_NEW"] = 'New VDoc';
$lang["PROC_VDOC_TASK_NEW"] = 'New Topic';
$lang["PROC_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["PROC_VDOC_HELP"] = 'manual_prozesse_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>