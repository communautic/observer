<?php
$publishers_menues_name = "Menues";

$lang["PUBLISHER_MENUE_TITLE"] = 'Menue';
$lang["PUBLISHER_MENUES"] = 'Menues';

$lang["PUBLISHER_MENUE_NEW"] = 'New Menue';
$lang["PUBLISHER_MENUE_ACTION_NEW"] = 'new Menue';

$lang["PUBLISHER_MENUE_DATE"] = 'Date';
$lang["PUBLISHER_MENUE_TIME_START"] = 'Start';
$lang["PUBLISHER_MENUE_TIME_END"] = 'End';

$lang["PUBLISHER_MENUE_MANAGEMENT"] = 'With';
$lang["PUBLISHER_MENUE_GOALS"] = 'Agenda';

$lang["PUBLISHER_MENUE_STATUS_OUTGOING"] = 'incoming';
$lang["PUBLISHER_MENUE_STATUS_ON_INCOMING"] = 'outgoing';

$lang["PUBLISHER_MENUE_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["PUBLISHER_PRINT_MENUE"] = 'menue.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/publishers/menues/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>