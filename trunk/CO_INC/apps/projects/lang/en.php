<?php
// App name
$projects_name = "Projects";

// Left
$lang["PROJECT_FOLDER"] = 'Folder';
$lang["PROJECT_FOLDER_NEW"] = 'New Folder';
$lang["PROJECT_PROJECTS"] = 'Projects';
$lang["PROJECT_NEW"] = 'New Project';

// Folder Right
$lang["PROJECT_FOLDER_PROJECTS_CREATED"] = 'Total Projects';
$lang["PROJECT_FOLDER_PROJECTS_PLANNED"] = 'planned';
$lang["PROJECT_FOLDER_PROJECTS_RUNNING"] = 'in progress';
$lang["PROJECT_FOLDER_PROJECTS_FINISHED"] = 'completed';
$lang["PROJECT_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["PROJECT_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["PROJECT_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["PROJECT_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["PROJECT_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["PROJECT_FOLDER_CHART_TASKS"] = 'Stage Timeliness';

// Project Right
$lang["PROJECT_TITLE"] = 'Project';
$lang['PROJECT_KICKOFF'] = 'Kick Off';

$lang["PROJECT_CLIENT"] = 'Authorised by';
$lang["PROJECT_MANAGEMENT"] = 'Project Manager';
$lang["PROJECT_TEAM"] = 'Project Team';
$lang["PROJECT_DESCRIPTION"] = 'Description';

$lang["PROJECT_STATUS_PLANNED"] = 'planned';
$lang["PROJECT_STATUS_INPROGRESS"] = 'started';
$lang["PROJECT_STATUS_FINISHED"] = 'completed';
$lang["PROJECT_PHASES"] = 'Phases';
$lang["PROJECT_MEETINGS"] = 'Meetings';

$lang["PROJECT_HANDBOOK"] = 'Project Manual';

// Print images
$lang["PRINT_PROJECT_MANUAL"] = 'project_manual.png';
$lang["PRINT_PROJECT"] = 'project.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>