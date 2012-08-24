<?php
$employees_objectives_name = "Objectives";

$lang["EMPLOYEE_OBJECTIVE_TITLE"] = 'Objective';
$lang["EMPLOYEE_OBJECTIVES"] = 'Objectives';

$lang["EMPLOYEE_OBJECTIVE_NEW"] = 'New Objective';
$lang["EMPLOYEE_OBJECTIVE_ACTION_NEW"] = 'new Objective';
$lang["EMPLOYEE_OBJECTIVE_TASK_NEW"] = 'New Item';
//define('OBJECTIVE_RELATES_TO', 'bezogen auf');
$lang["EMPLOYEE_OBJECTIVE_DATE"] = 'Date';
$lang["EMPLOYEE_OBJECTIVE_PLACE"] = 'Location';
$lang["EMPLOYEE_OBJECTIVE_TIME_START"] = 'Start';
$lang["EMPLOYEE_OBJECTIVE_TIME_END"] = 'End';

$lang["EMPLOYEE_OBJECTIVE_ATTENDEES"] = 'Attendees';
$lang["EMPLOYEE_OBJECTIVE_MANAGEMENT"] = 'Minuted by';
$lang["EMPLOYEE_OBJECTIVE_GOALS"] = 'Agenda';

$lang["EMPLOYEE_OBJECTIVE_POSPONED"] = 'posponed';


$lang["EMPLOYEE_OBJECTIVE_HELP"] = 'manual_mitarbeiter_zielvereinbarungen.pdf';

$lang["EMPLOYEE_PRINT_OBJECTIVE"] = 'objective.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/objectives/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>