<?php
$employees_comments_name = "Comments";

$lang["EMPLOYEE_COMMENT_TITLE"] = 'Comment';
$lang["EMPLOYEE_COMMENTS"] = 'Comments';

$lang["EMPLOYEE_COMMENT_NEW"] = 'New Comment';
$lang["EMPLOYEE_COMMENT_ACTION_NEW"] = 'new Comment';

$lang["EMPLOYEE_COMMENT_DATE"] = 'Date';
$lang["EMPLOYEE_COMMENT_TIME_START"] = 'Start';
$lang["EMPLOYEE_COMMENT_TIME_END"] = 'End';

$lang["EMPLOYEE_COMMENT_MANAGEMENT"] = 'With';
$lang["EMPLOYEE_COMMENT_TYPE"] = 'Call type';
$lang["EMPLOYEE_COMMENT_GOALS"] = 'Agenda';

$lang["EMPLOYEE_COMMENT_STATUS_OUTGOING"] = 'incoming';
$lang["EMPLOYEE_COMMENT_STATUS_ON_INCOMING"] = 'outgoing';

$lang["EMPLOYEE_COMMENT_HELP"] = 'manual_mitarbeiter_leistungskommentare.pdf';

$lang["EMPLOYEE_PRINT_COMMENT"] = 'comment.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/comments/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>