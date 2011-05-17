<?php
$access_name = "Access";

$lang["ACCESSRIGHTS"] = 'Access Rights';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>