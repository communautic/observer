<?php
$clients_phonecalls_name = "Phonecalls";

$lang["CLIENT_PHONECALL_TITLE"] = 'Phonecall';
$lang["CLIENT_PHONECALLS"] = 'Phonecalls';

$lang["CLIENT_PHONECALL_NEW"] = 'New Phonecall';
$lang["CLIENT_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["CLIENT_PHONECALL_DATE"] = 'Date';
$lang["CLIENT_PHONECALL_TIME_START"] = 'Start';
$lang["CLIENT_PHONECALL_TIME_END"] = 'End';

$lang["CLIENT_PHONECALL_MANAGEMENT"] = 'With';
$lang["CLIENT_PHONECALL_GOALS"] = 'Agenda';

$lang["CLIENT_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["CLIENT_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["CLIENT_PHONECALL_HELP"] = 'manual_kunden_telefonate.pdf';

$lang["CLIENT_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>