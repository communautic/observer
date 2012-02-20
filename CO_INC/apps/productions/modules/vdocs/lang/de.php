<?php
$productions_vdocs_name = "Textbeiträge";

$lang["PRODUCTION_VDOC_TITLE"] = 'Textbeitrag';
$lang["PRODUCTION_VDOC_VDOCS"] = 'Textbeiträge';
$lang["PRODUCTION_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["PRODUCTION_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["PRODUCTION_VDOC_HELP"] = 'manual_projekte_Textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>