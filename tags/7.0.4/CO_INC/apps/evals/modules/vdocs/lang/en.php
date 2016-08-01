<?php
$evals_vdocs_name = "Documents";

$lang["EVAL_VDOC_TITLE"] = 'Document';
$lang["EVAL_VDOC_VDOCS"] = 'Documents';
$lang["EVAL_VDOC_NEW"] = 'New Document';
$lang["EVAL_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["EVAL_VDOC_HELP"] = 'manual_mitarbeiter_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>