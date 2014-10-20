<?php
$publishers_menues_name = "Menues";

$lang["PUBLISHER_MENUE_TITLE"] = 'Menue';
$lang["PUBLISHER_MENUES"] = 'Menues';

$lang["PUBLISHER_MENUE_NEW"] = 'New Menue';
$lang["PUBLISHER_MENUE_ACTION_NEW"] = 'new Menue';

$lang["PUBLISHER_MENUE_DATE_FROM"] = 'valid from';
$lang["PUBLISHER_MENUE_DATE_TO"] = 'valid to';

$lang["PUBLISHER_MENUE_MANAGEMENT"] = 'Responsibility';
$lang["PUBLISHER_MENUE_GOALS"] = 'Description';

$lang["PUBLISHER_MENUE_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["PUBLISHER_PRINT_MENUE"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/publishers/menues/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>