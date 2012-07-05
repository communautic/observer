<?php
$clients_phonecalls_name = "Telefonate";

$lang["CLIENT_PHONECALL_TITLE"] = 'Telefonat';
$lang["CLIENT_PHONECALLS"] = 'Telefonate';

$lang["CLIENT_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["CLIENT_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["CLIENT_PHONECALL_DATE"] = 'Datum';
$lang["CLIENT_PHONECALL_TIME_START"] = 'Start';
$lang["CLIENT_PHONECALL_TIME_END"] = 'Ende';

$lang["CLIENT_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["CLIENT_PHONECALL_TYPE"] = 'Telefonieart';
$lang["CLIENT_PHONECALL_GOALS"] = 'Themen';

$lang["CLIENT_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["CLIENT_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["CLIENT_PHONECALL_HELP"] = 'manual_kunden_telefonate.pdf';

$lang["CLIENT_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>