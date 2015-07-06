<?php
$evals_objectives_name = "Objectives";

$lang["EVAL_OBJECTIVE_TITLE"] = 'Objective';
$lang["EVAL_OBJECTIVES"] = 'Objectives';

$lang["EVAL_OBJECTIVE_NEW"] = 'New Objective';
$lang["EVAL_OBJECTIVE_ACTION_NEW"] = 'new Objective';
$lang["EVAL_OBJECTIVE_TASK_NEW"] = 'New Item';
//define('OBJECTIVE_RELATES_TO', 'bezogen auf');
$lang["EVAL_OBJECTIVE_DATE"] = 'Date';
$lang["EVAL_OBJECTIVE_PLACE"] = 'Location';
$lang["EVAL_OBJECTIVE_TIME_START"] = 'Start';
$lang["EVAL_OBJECTIVE_TIME_END"] = 'End';

$lang["EVAL_OBJECTIVE_ATTENDEES"] = 'Attendees';
$lang["EVAL_OBJECTIVE_MANAGEMENT"] = 'Minuted by';
$lang["EVAL_OBJECTIVE_GOALS"] = 'Agenda';

$lang["EVAL_OBJECTIVE_POSPONED"] = 'posponed';


$lang["EVAL_OBJECTIVE_HELP"] = 'manual_mitarbeiter_zielvereinbarungen.pdf';

$lang["EVAL_PRINT_OBJECTIVE"] = 'objective.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/objectives/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>