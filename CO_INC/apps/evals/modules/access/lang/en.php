<?php
$evals_access_name = "Access";

$lang["EVAL_ACCESSRIGHTS"] = 'Access Rights';

$lang["EVAL_ACCESS_HELP"] = 'manual_mitarbeiter_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>