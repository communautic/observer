<?php
$evals_vdocs_name = "Textbeiträge";

$lang["EVAL_VDOC_TITLE"] = 'Textbeitrag';
$lang["EVAL_VDOC_VDOCS"] = 'Textbeiträge';
$lang["EVAL_VDOC_NEW"] = 'Neuer Textbeitrag';
$lang["EVAL_VDOC_ACTION_NEW"] = 'neuen Texbeitrag anlegen';

$lang["EVAL_VDOC_HELP"] = 'manual_mitarbeiter_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>