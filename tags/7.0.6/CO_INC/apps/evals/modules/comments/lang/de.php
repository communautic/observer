<?php
$evals_comments_name = "Kommentare";

$lang["EVAL_COMMENT_TITLE"] = 'Kommentar';
$lang["EVAL_COMMENTS"] = 'Kommentare';

$lang["EVAL_COMMENT_NEW"] = 'Neuer Kommentar';
$lang["EVAL_COMMENT_ACTION_NEW"] = 'neuen Kommentar anlegen';

$lang["EVAL_COMMENT_DATE"] = 'Datum';
$lang["EVAL_COMMENT_TIME_START"] = 'Start';
$lang["EVAL_COMMENT_TIME_END"] = 'Ende';

$lang["EVAL_COMMENT_MANAGEMENT"] = 'Verfasser';
$lang["EVAL_COMMENT_TYPE"] = 'Telefonieart';
$lang["EVAL_COMMENT_GOALS"] = 'Notiz';

$lang["EVAL_COMMENT_HELP"] = 'manual_mitarbeiter_leistungskommentare.pdf';

$lang["EVAL_PRINT_COMMENT"] = 'kommentar.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/comments/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>