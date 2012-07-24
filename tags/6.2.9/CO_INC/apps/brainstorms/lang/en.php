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
$lang["BRAINSTORM_FOLDER_CREATED_ON"] = 'created on';
$lang["BRAINSTORM_FOLDER_INITIATOR"] = 'created by';

$lang["BRAINSTORM_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["BRAINSTORM_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["BRAINSTORM_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["BRAINSTORM_FOLDER_CHART_TASKS"] = 'Stage Timeliness';

// Brainstorm Right
$lang["BRAINSTORM_TITLE"] = 'Brainstorm';
$lang['BRAINSTORM_NOTE_ADD'] = 'Notes';
$lang['BRAINSTORM_NOTE_NEW'] = 'new Note';

$lang["BRAINSTORM_CLIENT"] = 'Authorised by';
$lang["BRAINSTORM_MANAGEMENT"] = 'Brainstorm Manager';
$lang["BRAINSTORM_TEAM"] = 'Brainstorm Team';
$lang["BRAINSTORM_DESCRIPTION"] = 'Description';

// Bin
$lang['BRAINSTORM_TITLE_NOTES_BIN'] = 'Brainstorms/Notes';
$lang['BRAINSTORM_NOTE_BIN'] = 'Note';

$lang["BRAINSTORM_HANDBOOK"] = 'Brainstorm Manual';

$lang["BRAINSTORM_HELP"] = 'manual_prozesse_prozesse.pdf';
$lang["BRAINSTORM_FOLDER_HELP"] = 'manual_prozesse_ordner.pdf';

// Print images
$lang["PRINT_BRAINSTORM_MANUAL"] = 'brainstorm_manual.png';
$lang["PRINT_BRAINSTORM"] = 'brainstorm.png';
$lang["PRINT_BRAINSTORM_FOLDER"] = 'folder.png';

// Dektop Widget
$lang["BRAINSTORM_WIDGET_NO_ACTIVITY"]		=	'Currently there are no notices';
$lang["BRAINSTORM_WIDGET_TITLE_BRAINSTORM"]	=	'Brainstorm';
$lang["BRAINSTORM_WIDGET_INVITATION_ADMIN"]	=	'You have been invited as <span class="yellow">Administrator</span> to the brainstorm "%1$s"';
$lang["BRAINSTORM_WIDGET_INVITATION_GUEST"]	=	'You have been invited as <span class="yellow">Guest</span> to the brainstorm "%1$s"';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/brainstorms/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>