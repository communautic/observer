<?php
$procs_vdocs_name = "Documents";

$lang["PROC_VDOC_TITLE"] = 'Document';
$lang["PROC_VDOC_VDOCS"] = 'Documents';
$lang["PROC_VDOC_NEW"] = 'New Document';
$lang["PROC_VDOC_ACTION_NEW"] = 'new virtual document';

$lang["PROC_VDOC_HELP"] = 'manual_prozesse_textbeitraege.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/vdocs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>