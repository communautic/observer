<?php
$trainings_phonecalls_name = "Telefonate";

$lang["TRAINING_PHONECALL_TITLE"] = 'Telefonat';
$lang["TRAINING_PHONECALLS"] = 'Telefonate';

$lang["TRAINING_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["TRAINING_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["TRAINING_PHONECALL_DATE"] = 'Datum';
$lang["TRAINING_PHONECALL_TIME_START"] = 'Start';
$lang["TRAINING_PHONECALL_TIME_END"] = 'Ende';

$lang["TRAINING_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["TRAINING_PHONECALL_TYPE"] = 'Telefonieart';
$lang["TRAINING_PHONECALL_GOALS"] = 'Notiz';

$lang["TRAINING_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["TRAINING_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["TRAINING_PHONECALL_HELP"] = 'manual_trainings_telefonate.pdf';

$lang["TRAINING_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>