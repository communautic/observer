<?php
$employees_phonecalls_name = "Telefonate";

$lang["EMPLOYEE_PHONECALL_TITLE"] = 'Telefonat';
$lang["EMPLOYEE_PHONECALLS"] = 'Telefonate';

$lang["EMPLOYEE_PHONECALL_NEW"] = 'Neues Telefonat';
$lang["EMPLOYEE_PHONECALL_ACTION_NEW"] = 'neues Telefonat anlegen';

$lang["EMPLOYEE_PHONECALL_DATE"] = 'Datum';
$lang["EMPLOYEE_PHONECALL_TIME_START"] = 'Start';
$lang["EMPLOYEE_PHONECALL_TIME_END"] = 'Ende';

$lang["EMPLOYEE_PHONECALL_MANAGEMENT"] = 'Gesprächspartner';
$lang["EMPLOYEE_PHONECALL_TYPE"] = 'Telefonieart';
$lang["EMPLOYEE_PHONECALL_GOALS"] = 'Notiz';

$lang["EMPLOYEE_PHONECALL_STATUS_OUTGOING"] = 'Outgoing';
$lang["EMPLOYEE_PHONECALL_STATUS_ON_INCOMING"] = 'Incoming';

$lang["EMPLOYEE_PHONECALL_HELP"] = 'manual_reklamationen_telefonate.pdf';

$lang["EMPLOYEE_PRINT_PHONECALL"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/phonecalls/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>