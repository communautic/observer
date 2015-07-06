<?php
// App name
$procs_name = "Workplan";
$lang["procs_name"] = 'Workplan';

// Left
$lang["PROC_FOLDER"] = 'Folder';
$lang["PROC_FOLDER_NEW"] = 'New Folder';
$lang["PROC_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["PROC_PROCS"] = 'Workplan';
$lang["PROC_NEW"] = 'New Workplan';
$lang["PROC_ACTION_NEW"] = 'new Task';

$lang["PROC_NEW_OPTION_PROCESS"] = 'new Worklpan';
$lang["PROC_NEW_OPTION_PROCESSLINK"] = 'Workplan Link';

// Folder Right
$lang["PROC_FOLDER_CREATED_ON"] = 'created on';
$lang["PROC_FOLDER_INITIATOR"] = 'created by';

$lang["PROC_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["PROC_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["PROC_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["PROC_FOLDER_CHART_TASKS"] = 'Stage Timeliness';

// Proc Right
$lang["PROC_TITLE"] = 'Workplan';
$lang['PROC_NOTE_ADD'] = 'Notes';
$lang['PROC_NOTE_NEW'] = 'new Note';

$lang["PROC_CLIENT"] = 'Authorised by';
$lang["PROC_MANAGEMENT"] = 'Process Manager';
$lang["PROC_TEAM"] = 'Process Team';
$lang["PROC_DESCRIPTION"] = 'Description';

// Bin
$lang['PROC_TITLE_NOTES_BIN'] = 'Workplan/Notes';
$lang['PROC_NOTE_BIN'] = 'Note';

$lang["PROC_HANDBOOK"] = 'Workplan Guide';

$lang["PROC_HELP"] = 'manual_prozesse_prozesse.pdf';
$lang["PROC_FOLDER_HELP"] = 'manual_prozesse_ordner.pdf';

// Print images
$lang["PRINT_PROC_MANUAL"] = 'proc_manual.png';
$lang["PRINT_PROC"] = 'proc.png';
$lang["PRINT_PROC_FOLDER"] = 'folder.png';

// Dektop Widget
$lang["PROC_WIDGET_NO_ACTIVITY"]		=	'Currently there are no notices';
$lang["PROC_WIDGET_TITLE_PROC"]	=	'Proc';
$lang["PROC_WIDGET_INVITATION_ADMIN"]	=	'You have been invited as <span class="yellow">Administrator</span> to the proc "%1$s"';
$lang["PROC_WIDGET_INVITATION_GUEST"]	=	'You have been invited as <span class="yellow">Guest</span> to the proc "%1$s"';

/* Archiv */
$lang["PROC_ARCHIVE"] = 'Archived Workplans';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/procs/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>