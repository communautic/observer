<?php
$projects_vdocs_name = "vDocs";

$lang["PROJECT_VDOC_TITLE"] = 'vDoc';
$lang["PROJECT_VDOC_VDOCS"] = 'vDocs';
$lang["PROJECT_VDOC_NEW"] = 'Neues vDoc';
$lang["PROJECT_VDOC_ACTION_NEW"] = 'neues virtuelles Dokument anlegen';
$lang["PROJECT_VDOC_TASK_NEW"] = 'Neues Thema';
//define('VDOC_RELATES_TO', 'bezogen auf');
$lang["PROJECT_VDOC_DATE"] = 'Datum';
$lang["PROJECT_VDOC_PLACE"] = 'Ort';
$lang["PROJECT_VDOC_TIME_START"] = 'Start';
$lang["PROJECT_VDOC_TIME_END"] = 'Ende';

$lang["PROJECT_VDOC_ATTENDEES"] = 'Teilnehmer';
$lang["PROJECT_VDOC_MANAGEMENT"] = 'Protokollführer';
$lang["PROJECT_VDOC_GOALS"] = 'Themen';

$lang["PROJECT_VDOC_STATUS_PLANNED"] = 'in Planung';
$lang["PROJECT_VDOC_STATUS_ON_SCHEDULE"] = 'termingerecht abgehalten';
$lang["PROJECT_VDOC_STATUS_CANCELLED"] = 'abgesagt';
$lang["PROJECT_VDOC_STATUS_POSPONED"] = 'verschoben auf';
$lang["PROJECT_VDOC_POSPONED"] = 'verschoben';

$lang["PROJECT_VDOC_HELP"] = 'manual_projekte_vdoc.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/vdocs/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>