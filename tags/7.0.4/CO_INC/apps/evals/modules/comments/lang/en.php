<?php
$evals_comments_name = "Comments";

$lang["EVAL_COMMENT_TITLE"] = 'Comment';
$lang["EVAL_COMMENTS"] = 'Comments';

$lang["EVAL_COMMENT_NEW"] = 'New Comment';
$lang["EVAL_COMMENT_ACTION_NEW"] = 'new Comment';

$lang["EVAL_COMMENT_DATE"] = 'Date';
$lang["EVAL_COMMENT_TIME_START"] = 'Start';
$lang["EVAL_COMMENT_TIME_END"] = 'End';

$lang["EVAL_COMMENT_MANAGEMENT"] = 'With';
$lang["EVAL_COMMENT_TYPE"] = 'Call type';
$lang["EVAL_COMMENT_GOALS"] = 'Agenda';

$lang["EVAL_COMMENT_STATUS_OUTGOING"] = 'incoming';
$lang["EVAL_COMMENT_STATUS_ON_INCOMING"] = 'outgoing';

$lang["EVAL_COMMENT_HELP"] = 'manual_mitarbeiter_leistungskommentare.pdf';

$lang["EVAL_PRINT_COMMENT"] = 'comment.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/comments/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>