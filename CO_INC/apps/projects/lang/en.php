<?php
// App name
$projects_name = "Projects";

// Left
$lang["PROJECT_FOLDER"] = 'Folder';
$lang["PROJECT_FOLDER_NEW"] = 'New Folder';
$lang["PROJECT_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["PROJECT_PROJECTS"] = 'Projects';
$lang["PROJECT_NEW"] = 'New Project';
$lang["PROJECT_ACTION_NEW"] = 'new Project';

// Folder Right
$lang["PROJECT_FOLDER_PROJECTS_CREATED"] = 'Total Projects';
$lang["PROJECT_FOLDER_PROJECTS_PLANNED"] = 'planned';
$lang["PROJECT_FOLDER_PROJECTS_RUNNING"] = 'in progress';
$lang["PROJECT_FOLDER_PROJECTS_FINISHED"] = 'completed';
$lang["PROJECT_FOLDER_PROJECTS_STOPPED"] = 'stopped';
$lang["PROJECT_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["PROJECT_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["PROJECT_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["PROJECT_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["PROJECT_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["PROJECT_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["PROJECT_FOLDER_CHART_STATUS"] = 'Status';

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
$lang["PROJECT_STATUS_STOPPED"] = 'stopped';

$lang["PROJECT_STATUS_PLANNED_TEXT"] = 'planned';
$lang["PROJECT_STATUS_INPROGRESS_TEXT"] = 'started';
$lang["PROJECT_STATUS_FINISHED_TEXT"] = 'completed';
$lang["PROJECT_STATUS_STOPPED_TEXT"] = 'stopped';

$lang["PROJECT_HANDBOOK"] = 'Project Manual';

$lang["PROJECT_HELP"] = 'manual_projekte_projekte.pdf';
$lang["PROJECT_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_PROJECT_MANUAL"] = 'project_manual.png';
$lang["PRINT_PROJECT"] = 'project.png';
$lang["PRINT_PROJECT_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>