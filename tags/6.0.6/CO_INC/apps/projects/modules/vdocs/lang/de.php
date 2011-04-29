<?php
$vdocs_name = "vDocs";

$lang["VDOC_TITLE"] = 'vDoc';
$lang["VDOC_VDOCS"] = 'vDocs';
$lang["VDOC_NEW"] = 'Neues vDoc';
$lang["VDOC_TASK_NEW"] = 'Neues Thema';
//define('VDOC_RELATES_TO', 'bezogen auf');
$lang["VDOC_DATE"] = 'Datum';
$lang["VDOC_PLACE"] = 'Ort';
$lang["VDOC_TIME_START"] = 'Start';
$lang["VDOC_TIME_END"] = 'Ende';

$lang["VDOC_ATTENDEES"] = 'Teilnehmer';
$lang["VDOC_MANAGEMENT"] = 'Protokollführer';
$lang["VDOC_GOALS"] = 'Themen';

$lang["VDOC_STATUS_PLANNED"] = 'in Planung';
$lang["VDOC_STATUS_ON_SCHEDULE"] = 'termingerecht abgehalten';
$lang["VDOC_STATUS_CANCELLED"] = 'abgesagt';
$lang["VDOC_STATUS_POSPONED"] = 'verschoben auf';
$lang["VDOC_POSPONED"] = 'verschoben';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>