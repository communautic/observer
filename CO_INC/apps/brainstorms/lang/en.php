<?php
// App name
$brainstorms_name = "Brainstorms";

// Left
$lang["BRAINSTORM_FOLDER"] = 'Folder';
$lang["BRAINSTORM_FOLDER_NEW"] = 'New Folder';
$lang["BRAINSTORM_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["BRAINSTORM_BRAINSTORMS"] = 'Brainstorms';
$lang["BRAINSTORM_NEW"] = 'New Brainstorm';
$lang["BRAINSTORM_ACTION_NEW"] = 'new Idea';

// Folder Right
$lang["BRAINSTORM_FOLDER_BRAINSTORMS_CREATED"] = 'Total Brainstorms';
$lang["BRAINSTORM_FOLDER_BRAINSTORMS_PLANNED"] = 'planned';
$lang["BRAINSTORM_FOLDER_BRAINSTORMS_RUNNING"] = 'in progress';
$lang["BRAINSTORM_FOLDER_BRAINSTORMS_FINISHED"] = 'completed';
$lang["BRAINSTORM_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["BRAINSTORM_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["BRAINSTORM_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["BRAINSTORM_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["BRAINSTORM_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["BRAINSTORM_FOLDER_CHART_TASKS"] = 'Stage Timeliness';

// Brainstorm Right
$lang["BRAINSTORM_TITLE"] = 'Brainstorm';
$lang['BRAINSTORM_KICKOFF'] = 'Kick Off';

$lang["BRAINSTORM_CLIENT"] = 'Authorised by';
$lang["BRAINSTORM_MANAGEMENT"] = 'Brainstorm Manager';
$lang["BRAINSTORM_TEAM"] = 'Brainstorm Team';
$lang["BRAINSTORM_DESCRIPTION"] = 'Description';

$lang["BRAINSTORM_STATUS_PLANNED"] = 'planned';
$lang["BRAINSTORM_STATUS_INPROGRESS"] = 'started';
$lang["BRAINSTORM_STATUS_FINISHED"] = 'completed';
$lang["BRAINSTORM_STATUS_STOPPED"] = 'stopped';

$lang["BRAINSTORM_HANDBOOK"] = 'Brainstorm Manual';

// Print images
$lang["PRINT_BRAINSTORM_MANUAL"] = 'brainstorm_manual.png';
$lang["PRINT_BRAINSTORM"] = 'brainstorm.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>