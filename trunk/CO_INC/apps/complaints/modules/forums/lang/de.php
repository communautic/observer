<?php
$complaints_forums_name = "Diskussion";

$lang["COMPLAINT_FORUM_TITLE"] = 'Diskussion';
$lang["COMPLAINT_FORUMS"] = 'Diskussionen';

$lang["COMPLAINT_FORUM_NEW"] = 'Neue Diskussion';
$lang["COMPLAINT_FORUM_ACTION_NEW"] = 'neue Diskussion anlegen';

$lang["COMPLAINT_FORUM_QUESTION"] = 'Frage';
$lang["COMPLAINT_FORUM_ANSWERS"] = 'Antwort';
$lang["COMPLAINT_FORUM_DISCUSSION"] = 'Diskussion';

$lang["COMPLAINT_FORUM_DATE"] = 'Datum';
$lang["COMPLAINT_FORUM_PLACE"] = 'Ort';
$lang["COMPLAINT_FORUM_TIME_START"] = 'Start';
$lang["COMPLAINT_FORUM_TIME_END"] = 'Ende';

$lang["COMPLAINT_FORUM_ATTENDEES"] = 'Teilnehmer';
$lang["COMPLAINT_FORUM_MANAGEMENT"] = 'Protokollführer';
$lang["COMPLAINT_FORUM_GOALS"] = 'Antworten';

$lang["COMPLAINT_FORUM_STATUS_PLANNED"] = 'in Planung seit';
$lang["COMPLAINT_FORUM_STATUS_INPROGRESS"] = 'in Diskussion seit';
$lang["COMPLAINT_FORUM_STATUS_FINISHED"] = 'abgeschlossen am';
$lang["COMPLAINT_FORUM_STATUS_STOPPED"] = 'abgebrochen am';

$lang["COMPLAINT_FORUM_POSTS"] = 'Foren / Antworten';

$lang["COMPLAINT_FORUM_HELP"] = 'manual_reklamationen_diskussionen.pdf';

$lang["COMPLAINT_PRINT_FORUM"] = 'diskussion.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/forums/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>