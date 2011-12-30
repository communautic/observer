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

// Dektop Widget
$lang["PROJECT_WIDGET_NO_ACTIVITY"]			=	'Currently there are no notices';
$lang["PROJECT_WIDGET_TITLE_MILESTONE"] 	=	'Milestone';
$lang["PROJECT_WIDGET_REMINDER_MILESTONE"] 	= 	'Für <span class="yellow">morgen</span> ist die Erreichung des Meilensteins "%1$s" im Projekt "%2$s" geplant';

$lang["PROJECT_WIDGET_TITLE_TASK"] 			=	'Stage';
$lang["PROJECT_WIDGET_REMINDER_TASK"] 		= 	'Für <span class="yellow">morgen</span> ist die Erreichung des Arbeitspaketes "%1$s" im Projekt "%2$s" geplant';

$lang["PROJECT_WIDGET_TITLE_KICKOFF"] 		=	'Kick Off';
$lang["PROJECT_WIDGET_REMINDER_KICKOFF"] 	= 	'Für <span class="yellow">morgen</span> ist der Kick Off des Projektes "%1$s" geplant';

$lang["PROJECT_WIDGET_ALERT_TASK"] 			= 	'Der Arbeitspaket Fälligkeitstermin für "%1$s" im Projekt "%2$s" ist <span class="yellow">außer Plan</span>';
$lang["PROJECT_WIDGET_ALERT_MILESTONE"] 	= 	'Der Meilenstein Fälligkeitstermin für "%1$s" im Projekt "%2$s" ist <span class="yellow">außer Plan</span>';

$lang["PROJECT_WIDGET_TITLE_PROJECT"]		=	'Projekt';
$lang["PROJECT_WIDGET_INVITATION_ADMIN"]	=	'You have been invited as <span class="yellow">Administrator</span> to the project "%1$s"';
$lang["PROJECT_WIDGET_INVITATION_GUEST"]	=	'You have been invited as <span class="yellow">Guest</span> to the project "%1$s"';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>