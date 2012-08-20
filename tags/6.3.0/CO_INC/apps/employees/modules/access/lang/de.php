<?php
$employees_access_name = "Zugang";

$lang["EMPLOYEE_ACCESSRIGHTS"] = 'Berechtigungen';

$lang["EMPLOYEE_ACCESS_HELP"] = 'manual_reklamationen_zugang.pdf';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>