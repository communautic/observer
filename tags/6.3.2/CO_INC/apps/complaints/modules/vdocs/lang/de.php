<?php
$complaints_vdocs_name = "Textbeiträge";

$lang["COMPLAINT_VDOC_TITLE"] = 'Textbeitrag';
$lang["COMPLAINT_VDOC_VDOCS"] = 'Textbeiträge';
$lang["COMPLAINT_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["COMPLAINT_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["COMPLAINT_VDOC_HELP"] = 'manual_reklamationen_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>