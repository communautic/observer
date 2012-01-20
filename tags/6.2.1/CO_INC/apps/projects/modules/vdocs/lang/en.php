<?php
$projects_vdocs_name = "VDocs";

$lang["PROJECT_VDOC_TITLE"] = 'VDoc';
$lang["PROJECT_VDOC_NEW"] = 'New VDoc';
$lang["PROJECT_VDOC_TASK_NEW"] = 'New Topic';
$lang["PROJECT_VDOC_ACTION_NEW"] = 'new virtual document';
//define('VDOC_RELATES_TO', 'bezogen auf');
$lang["PROJECT_VDOC_DATE"] = 'Date';
$lang["PROJECT_VDOC_PLACE"] = 'Place';
$lang["PROJECT_VDOC_TIME_START"] = 'Start';
$lang["PROJECT_VDOC_TIME_END"] = 'End';

$lang["PROJECT_VDOC_ATTENDEES"] = 'Attendees';
$lang["PROJECT_VDOC_MANAGEMENT"] = 'Recorder';
$lang["PROJECT_VDOC_GOALS"] = 'Topics';

$lang["PROJECT_VDOC_STATUS_PLANNED"] = 'planned';
$lang["PROJECT_VDOC_STATUS_ON_SCHEDULE"] = 'held on time';
$lang["PROJECT_VDOC_STATUS_CANCELLED"] = 'cancelled';
$lang["PROJECT_VDOC_STATUS_POSPONED"] = 'posponed to';
$lang["PROJECT_VDOC_POSPONED"] = 'posponed';

$lang["PROJECT_VDOC_HELP"] = 'manual_projekte_vdoc.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>