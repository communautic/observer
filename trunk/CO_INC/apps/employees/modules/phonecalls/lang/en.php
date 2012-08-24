<?php
$employees_phonecalls_name = "Phonecalls";

$lang["EMPLOYEE_PHONECALL_TITLE"] = 'Phonecall';
$lang["EMPLOYEE_PHONECALLS"] = 'Phonecalls';

$lang["EMPLOYEE_PHONECALL_NEW"] = 'New Phonecall';
$lang["EMPLOYEE_PHONECALL_ACTION_NEW"] = 'new Phonecall';

$lang["EMPLOYEE_PHONECALL_DATE"] = 'Date';
$lang["EMPLOYEE_PHONECALL_TIME_START"] = 'Start';
$lang["EMPLOYEE_PHONECALL_TIME_END"] = 'End';

$lang["EMPLOYEE_PHONECALL_MANAGEMENT"] = 'With';
$lang["EMPLOYEE_PHONECALL_TYPE"] = 'Call type';
$lang["EMPLOYEE_PHONECALL_GOALS"] = 'Agenda';

$lang["EMPLOYEE_PHONECALL_STATUS_OUTGOING"] = 'incoming';
$lang["EMPLOYEE_PHONECALL_STATUS_ON_INCOMING"] = 'outgoing';

$lang["EMPLOYEE_PHONECALL_HELP"] = 'manual_mitarbeiter_telefonate.pdf';

$lang["EMPLOYEE_PRINT_PHONECALL"] = 'phonecall.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/phonecalls/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>