<?php
$vdocs_name = "VDocs";

$lang["VDOC_TITLE"] = 'VDoc';
$lang["VDOC_NEW"] = 'New VDoc';
$lang["VDOC_TASK_NEW"] = 'New Topic';
//define('VDOC_RELATES_TO', 'bezogen auf');
$lang["VDOC_DATE"] = 'Date';
$lang["VDOC_PLACE"] = 'Place';
$lang["VDOC_TIME_START"] = 'Start';
$lang["VDOC_TIME_END"] = 'End';

$lang["VDOC_ATTENDEES"] = 'Attendees';
$lang["VDOC_MANAGEMENT"] = 'Recorder';
$lang["VDOC_GOALS"] = 'Topics';

$lang["VDOC_STATUS_PLANNED"] = 'planned';
$lang["VDOC_STATUS_ON_SCHEDULE"] = 'held on time';
$lang["VDOC_STATUS_CANCELLED"] = 'cancelled';
$lang["VDOC_STATUS_POSPONED"] = 'posponed to';
$lang["VDOC_POSPONED"] = 'posponed';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>