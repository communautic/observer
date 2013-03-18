<?php
// App name
$publishers_name = "Publishers";

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/publishers/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>