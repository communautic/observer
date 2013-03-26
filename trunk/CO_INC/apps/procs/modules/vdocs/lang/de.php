<?php
$procs_vdocs_name = "Textbeiträge";

$lang["PROC_VDOC_TITLE"] = 'Textbeitrag';
$lang["PROC_VDOC_VDOCS"] = 'Textbeiträge';
$lang["PROC_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["PROC_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["PROC_VDOC_HELP"] = 'manual_prozesse_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>