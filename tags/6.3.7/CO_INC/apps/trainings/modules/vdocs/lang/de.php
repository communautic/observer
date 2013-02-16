<?php
$trainings_vdocs_name = "Textbeiträge";

$lang["TRAINING_VDOC_TITLE"] = 'Textbeitrag';
$lang["TRAINING_VDOC_VDOCS"] = 'Textbeiträge';
$lang["TRAINING_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["TRAINING_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["TRAINING_VDOC_HELP"] = 'manual_reklamationen_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>