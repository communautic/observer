<?php
// App name
$productions_name = "Productions";

// Left
$lang["PRODUCTION_FOLDER"] = 'Folder';
$lang["PRODUCTION_FOLDER_NEW"] = 'New Folder';
$lang["PRODUCTION_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["PRODUCTION_PRODUCTIONS"] = 'Productions';
$lang["PRODUCTION_NEW"] = 'New Production';
$lang["PRODUCTION_ACTION_NEW"] = 'new Production';

// Folder Right
$lang["PRODUCTION_FOLDER_TAB_PRODUCTIONS"] = 'Productions';
$lang["PRODUCTION_FOLDER_TAB_MULTIVIEW"] = 'Multi View';
$lang["PRODUCTION_FOLDER_TAB_STATUS"] = 'Folder Status';

$lang["PRODUCTION_FOLDER_PRODUCTIONS_CREATED"] = 'Total Productions';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_PLANNED"] = 'planned';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_RUNNING"] = 'in progress';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_FINISHED"] = 'completed';
$lang["PRODUCTION_FOLDER_PRODUCTIONS_STOPPED"] = 'stopped';
$lang["PRODUCTION_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["PRODUCTION_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["PRODUCTION_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["PRODUCTION_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["PRODUCTION_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["PRODUCTION_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["PRODUCTION_FOLDER_CHART_STATUS"] = 'Status';

// Production Right
$lang["PRODUCTION_TITLE"] = 'Production';
$lang['PRODUCTION_KICKOFF'] = 'Kick Off';

$lang["PRODUCTION_CLIENT"] = 'Authorised by';
$lang["PRODUCTION_MANAGEMENT"] = 'Production Manager';
$lang["PRODUCTION_TEAM"] = 'Production Team';
$lang["PRODUCTION_DESCRIPTION"] = 'Description';

$lang["PRODUCTION_STATUS_PLANNED"] = 'planned';
$lang["PRODUCTION_STATUS_INPROGRESS"] = 'started';
$lang["PRODUCTION_STATUS_FINISHED"] = 'completed';
$lang["PRODUCTION_STATUS_STOPPED"] = 'stopped';

$lang["PRODUCTION_STATUS_PLANNED_TEXT"] = 'planned';
$lang["PRODUCTION_STATUS_INPROGRESS_TEXT"] = 'started';
$lang["PRODUCTION_STATUS_FINISHED_TEXT"] = 'completed';
$lang["PRODUCTION_STATUS_STOPPED_TEXT"] = 'stopped';

$lang["PRODUCTION_HANDBOOK"] = 'Production Manual';

$lang["PRODUCTION_HELP"] = 'manual_projekte_projekte.pdf';
$lang["PRODUCTION_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_PRODUCTION_MANUAL"] = 'production_manual.png';
$lang["PRINT_PRODUCTION"] = 'production.png';
$lang["PRINT_PRODUCTION_FOLDER"] = 'folder.png';

// Dektop Widget
$lang["PRODUCTION_WIDGET_NO_ACTIVITY"]			=	'Currently there are no notices';
$lang["PRODUCTION_WIDGET_TITLE_MILESTONE"] 	=	'Milestone';
$lang["PRODUCTION_WIDGET_REMINDER_MILESTONE"] 	= 	'<span class="yellow">Tomorrow</span> you planned to reach the Milestone "%1$s" of the Production "%2$s"';

$lang["PRODUCTION_WIDGET_TITLE_TASK"] 			=	'Stage';
$lang["PRODUCTION_WIDGET_REMINDER_TASK"] 		= 	'<span class="yellow">Tomorrow</span> you planned to reach the Stage "%1$s" of the Production "%2$s"';

$lang["PRODUCTION_WIDGET_TITLE_KICKOFF"] 		=	'Kick Off';
$lang["PRODUCTION_WIDGET_REMINDER_KICKOFF"] 	= 	'<span class="yellow">Tomorrow</span> you planned the Kick Off for the Production "%1$s"';

$lang["PRODUCTION_WIDGET_ALERT_TASK"] 			= 	'The Stage "%1$s" in the Production "%2$s" is <span class="yellow">out of plan</span>';
$lang["PRODUCTION_WIDGET_ALERT_MILESTONE"] 	= 	'The Milestone "%1$s" in the Production "%2$s" is <span class="yellow">out of plan</span>';

$lang["PRODUCTION_WIDGET_TITLE_PRODUCTION"]		=	'Projekt';
$lang["PRODUCTION_WIDGET_INVITATION_ADMIN"]	=	'You have been invited as <span class="yellow">Administrator</span> to the Production "%1$s"';
$lang["PRODUCTION_WIDGET_INVITATION_GUEST"]	=	'You have been invited as <span class="yellow">Guest</span> to the Production "%1$s"';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/productions/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>