<?php
// App name
$archives_name = "Archives";
$lang["archives_name"] = "Archives";

// Left
$lang["ARCHIVE_FOLDER"] = 'Folder';
$lang["ARCHIVE_FOLDER_NEW"] = 'New Folder';
$lang["ARCHIVE_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["ARCHIVE_ARCHIVES"] = 'Archives';
$lang["ARCHIVE_NEW"] = 'New Archive';
$lang["ARCHIVE_ACTION_NEW"] = 'new Archive';

// Folder Right
$lang["ARCHIVE_FOLDER_TAB_ARCHIVES"] = 'Archives';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW"] = 'Multi View';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW_TIME"] = 'Schedule';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW_MANAGEMENT"] = 'Managers';
$lang["ARCHIVE_FOLDER_TAB_MULTIVIEW_STATUS"] = 'Status';
$lang["ARCHIVE_FOLDER_TAB_STATUS"] = 'Performance';

$lang["ARCHIVE_FOLDER_ARCHIVES_CREATED"] = 'Total Archives';
$lang["ARCHIVE_FOLDER_ARCHIVES_PLANNED"] = 'planned';
$lang["ARCHIVE_FOLDER_ARCHIVES_RUNNING"] = 'in progress';
$lang["ARCHIVE_FOLDER_ARCHIVES_FINISHED"] = 'completed';
$lang["ARCHIVE_FOLDER_ARCHIVES_STOPPED"] = 'stopped';
$lang["ARCHIVE_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["ARCHIVE_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["ARCHIVE_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["ARCHIVE_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["ARCHIVE_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["ARCHIVE_FOLDER_CHART_TASKS"] = 'Tasks Timeliness';
$lang["ARCHIVE_FOLDER_CHART_STATUS"] = 'Status';

// Archive Right
$lang["ARCHIVE_TITLE"] = 'Archive';
$lang['ARCHIVE_KICKOFF'] = 'Kick Off';

$lang["ARCHIVE_CLIENT"] = 'Authorised by';
$lang["ARCHIVE_MANAGEMENT"] = 'Archive Manager';
$lang["ARCHIVE_TEAM"] = 'Archive Team';

$lang["ARCHIVE_COSTS_PLAN"] = 'Planned Costs';
$lang["ARCHIVE_COSTS_REAL"] = 'Actual Costs';

$lang["ARCHIVE_DESCRIPTION"] = 'Description';

$lang["ARCHIVE_HANDBOOK"] = 'Archive Guide';

$lang["ARCHIVE_HELP"] = 'manual_projekte_projekte.pdf';
$lang["ARCHIVE_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_ARCHIVE_MANUAL"] = 'archive_manual.png';
$lang["PRINT_ARCHIVE"] = 'archive.png';
$lang["PRINT_ARCHIVE_FOLDER"] = 'folder.png';

// Dektop Widget
$lang["ARCHIVE_WIDGET_NO_ACTIVITY"]			=	'Currently there are no notices';
$lang["ARCHIVE_WIDGET_TITLE_MILESTONE"] 	=	'Milestone';
$lang["ARCHIVE_WIDGET_REMINDER_MILESTONE"] 	= 	'<span class="yellow">Tomorrow</span> you planned to reach the Milestone "%1$s" of the Archive "%2$s"';

$lang["ARCHIVE_WIDGET_TITLE_TASK"] 			=	'Task';
$lang["ARCHIVE_WIDGET_REMINDER_TASK"] 		= 	'<span class="yellow">Tomorrow</span> you planned to reach the Task "%1$s" of the Archive "%2$s"';

$lang["ARCHIVE_WIDGET_TITLE_KICKOFF"] 		=	'Kick Off';
$lang["ARCHIVE_WIDGET_REMINDER_KICKOFF"] 	= 	'<span class="yellow">Tomorrow</span> you planned the Kick Off for the Archive "%1$s"';

$lang["ARCHIVE_WIDGET_ALERT_TASK"] 			= 	'The Task "%1$s" in the Archive "%2$s" is <span class="yellow">out of plan</span>';
$lang["ARCHIVE_WIDGET_ALERT_MILESTONE"] 	= 	'The Milestone "%1$s" in the Archive "%2$s" is <span class="yellow">out of plan</span>';

$lang["ARCHIVE_WIDGET_TITLE_ARCHIVE"]		=	'Projekt';
$lang["ARCHIVE_WIDGET_INVITATION_ADMIN"]	=	'You have been invited as <span class="yellow">Administrator</span> to the Archive "%1$s"';
$lang["ARCHIVE_WIDGET_INVITATION_GUEST"]	=	'You have been invited as <span class="yellow">Guest</span> to the Archive "%1$s"';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/archives/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>