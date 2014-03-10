<?php
$projects_vdocs_name = "Documents";

$lang["PROJECT_VDOC_TITLE"] = 'Document';
$lang["PROJECT_VDOC_VDOCS"] = 'Documents';
$lang["PROJECT_VDOC_NEW"] = 'New Document';
$lang["PROJECT_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["PROJECT_VDOC_HELP"] = 'manual_projekte_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>