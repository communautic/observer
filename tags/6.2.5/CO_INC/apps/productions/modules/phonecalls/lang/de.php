<?php
$productions_phonecalls_name = "Telefonate";

$lang["PRODUCTION_PHONECALL_TITLE"] = 'Telefonat';
$lang["PRODUCTION_PHONECALLS"] = 'Telefonate';

$lang["PRODUCTION_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["PRODUCTION_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["PRODUCTION_PHONECALL_DATE"] = 'Datum';
$lang["PRODUCTION_PHONECALL_TIME_START"] = 'Start';
$lang["PRODUCTION_PHONECALL_TIME_END"] = 'Ende';

$lang["PRODUCTION_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["PRODUCTION_PHONECALL_GOALS"] = 'Themen';

$lang["PRODUCTION_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["PRODUCTION_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["PRODUCTION_PHONECALL_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["PRODUCTION_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>