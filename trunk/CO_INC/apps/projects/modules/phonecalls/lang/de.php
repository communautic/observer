<?php
$projects_phonecalls_name = "Telefonate";

$lang["PROJECT_PHONECALL_TITLE"] = 'Telefonat';
$lang["PROJECT_PHONECALLS"] = 'Telefonate';

$lang["PROJECT_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["PROJECT_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["PROJECT_PHONECALL_DATE"] = 'Datum';
$lang["PROJECT_PHONECALL_TIME_START"] = 'Start';
$lang["PROJECT_PHONECALL_TIME_END"] = 'Ende';

$lang["PROJECT_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["PROJECT_PHONECALL_TYPE"] = 'Telefonieart';
$lang["PROJECT_PHONECALL_GOALS"] = 'Themen';

$lang["PROJECT_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["PROJECT_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["PROJECT_PHONECALL_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["PROJECT_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>