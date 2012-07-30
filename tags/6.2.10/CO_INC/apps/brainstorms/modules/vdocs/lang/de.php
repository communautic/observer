<?php
$brainstorms_vdocs_name = "Textbeiträge";

$lang["BRAINSTORM_VDOC_TITLE"] = 'Textbeitrag';
$lang["BRAINSTORM_VDOC_VDOCS"] = 'Textbeiträge';
$lang["BRAINSTORM_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["BRAINSTORM_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["BRAINSTORM_VDOC_HELP"] = 'manual_prozesse_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>