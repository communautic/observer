<?php
$patients_comments_name = "Comments";

$lang["PATIENT_COMMENT_TITLE"] = 'Comment';
$lang["PATIENT_COMMENTS"] = 'Comments';

$lang["PATIENT_COMMENT_NEW"] = 'New Comment';
$lang["PATIENT_COMMENT_ACTION_NEW"] = 'new Comment';

$lang["PATIENT_COMMENT_DATE"] = 'Date';
$lang["PATIENT_COMMENT_TIME_START"] = 'Start';
$lang["PATIENT_COMMENT_TIME_END"] = 'End';

$lang["PATIENT_COMMENT_MANAGEMENT"] = 'With';
$lang["PATIENT_COMMENT_TYPE"] = 'Call type';
$lang["PATIENT_COMMENT_GOALS"] = 'Agenda';

$lang["PATIENT_COMMENT_STATUS_OUTGOING"] = 'incoming';
$lang["PATIENT_COMMENT_STATUS_ON_INCOMING"] = 'outgoing';

$lang["PATIENT_COMMENT_HELP"] = 'manual_mitarbeiter_leistungskommentare.pdf';

$lang["PATIENT_PRINT_COMMENT"] = 'comment.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/comments/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>