<?php
$projects_vdocs_name = "Textbeiträge";

$lang["PROJECT_VDOC_TITLE"] = 'Textbeitrag';
$lang["PROJECT_VDOC_VDOCS"] = 'Textbeiträge';
$lang["PROJECT_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["PROJECT_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["PROJECT_VDOC_HELP"] = 'manual_projekte_Textbeittraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>