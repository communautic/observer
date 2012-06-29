<?php
$complaints_vdocs_name = "VDocs";

$lang["COMPLAINT_VDOC_TITLE"] = 'VDoc';
$lang["COMPLAINT_VDOC_NEW"] = 'New VDoc';
$lang["COMPLAINT_VDOC_TASK_NEW"] = 'New Topic';
$lang["COMPLAINT_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["COMPLAINT_VDOC_HELP"] = 'manual_reklamationen_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>