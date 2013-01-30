<?php
$trainings_vdocs_name = "VDocs";

$lang["TRAINING_VDOC_TITLE"] = 'VDoc';
$lang["TRAINING_VDOC_NEW"] = 'New VDoc';
$lang["TRAINING_VDOC_TASK_NEW"] = 'New Topic';
$lang["TRAINING_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["TRAINING_VDOC_HELP"] = 'manual_reklamationen_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>