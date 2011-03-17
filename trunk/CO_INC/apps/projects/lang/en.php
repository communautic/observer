<?php
// App name
$projects_name = "Projects";

// Left
$lang["PROJECT_FOLDER"] = 'Folder';
$lang["PROJECT_FOLDER_NEW"] = 'New Folder';
$lang["PROJECT_PROJECTS"] = 'Projects';
$lang["PROJECT_NEW"] = 'New Project';

// Folder Right
$lang["PROJECT_FOLDER_PROJECTS_CREATED"] = 'Projects total';
$lang["PROJECT_FOLDER_PROJECTS_PLANNED"] = 'Projects planned';
$lang["PROJECT_FOLDER_PROJECTS_RUNNING"] = 'Projects in progress';
$lang["PROJECT_FOLDER_PROJECTS_FINISHED"] = 'Projects finished';
$lang["PROJECT_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["PROJECT_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["PROJECT_FOLDER_CHART_STABILITY"] = 'current Project stability';
$lang["PROJECT_FOLDER_CHART_REALISATION"] = 'Realisation';
$lang["PROJECT_FOLDER_CHART_ADHERANCE"] = 'Adherance to schedules';
$lang["PROJECT_FOLDER_CHART_TASKS"] = 'Tasks on time';

// Project Right
$lang["PROJECT_TITLE"] = 'Project';
$lang['PROJECT_KICKOFF'] = 'Kick Off';

$lang["PROJECT_CLIENT"] = 'Commissioner';
$lang["PROJECT_MANAGEMENT"] = 'Project Management';
$lang["PROJECT_TEAM"] = 'Project Team';
$lang["PROJECT_DESCRIPTION"] = 'Description';

$lang["PROJECT_STATUS_PLANNED"] = 'plannend since';
$lang["PROJECT_STATUS_INPROGRESS"] = 'in progress since';
$lang["PROJECT_STATUS_FINISHED"] = 'finished on';
$lang["PROJECT_PHASES"] = 'Phases';
$lang["PROJECT_MEETINGS"] = 'Meetings';

$lang["PROJECT_HANDBOOK"] = 'Project Handbook';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>