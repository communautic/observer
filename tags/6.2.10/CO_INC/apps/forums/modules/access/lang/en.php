<?php
$forums_access_name = "Access";

$lang["FORUM_ACCESSRIGHTS"] = 'Access Rights';

$lang["FORUM_ACCESS_HELP"] = 'manual_foren_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/forums/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>