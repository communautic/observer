<?php
$productions_vdocs_name = "VDocs";

$lang["PRODUCTION_VDOC_TITLE"] = 'VDoc';
$lang["PRODUCTION_VDOC_NEW"] = 'New VDoc';
$lang["PRODUCTION_VDOC_TASK_NEW"] = 'New Topic';
$lang["PRODUCTION_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["PRODUCTION_VDOC_HELP"] = 'manual_projekte_Textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>