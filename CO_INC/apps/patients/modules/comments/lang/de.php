<?php
$patients_comments_name = "Leistungskommentare";

$lang["PATIENT_COMMENT_TITLE"] = 'Leistungskommentar';
$lang["PATIENT_COMMENTS"] = 'Leistungskommentare';

$lang["PATIENT_COMMENT_NEW"] = 'Neuer Leistungskommentar';
$lang["PATIENT_COMMENT_ACTION_NEW"] = 'neuen Leistungskommentar anlegen';

$lang["PATIENT_COMMENT_DATE"] = 'Datum';
$lang["PATIENT_COMMENT_TIME_START"] = 'Start';
$lang["PATIENT_COMMENT_TIME_END"] = 'Ende';

$lang["PATIENT_COMMENT_MANAGEMENT"] = 'Verfasser';
$lang["PATIENT_COMMENT_TYPE"] = 'Telefonieart';
$lang["PATIENT_COMMENT_GOALS"] = 'Notiz';

$lang["PATIENT_COMMENT_HELP"] = 'manual_mitarbeiter_leistungskommentare.pdf';

$lang["PATIENT_PRINT_COMMENT"] = 'kommentar.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/comments/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>