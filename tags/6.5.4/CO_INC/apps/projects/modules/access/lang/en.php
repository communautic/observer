<?php
$projects_access_name = "Access";

$lang["PROJECT_ACCESSRIGHTS"] = 'Access Rights';

$lang["PROJECT_ACCESS_HELP"] = 'manual_projekte_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>