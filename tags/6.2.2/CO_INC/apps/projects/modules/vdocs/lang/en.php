<?php
$projects_vdocs_name = "VDocs";

$lang["PROJECT_VDOC_TITLE"] = 'VDoc';
$lang["PROJECT_VDOC_NEW"] = 'New VDoc';
$lang["PROJECT_VDOC_TASK_NEW"] = 'New Topic';
$lang["PROJECT_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["PROJECT_VDOC_HELP"] = 'manual_projekte_Textbeittraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>