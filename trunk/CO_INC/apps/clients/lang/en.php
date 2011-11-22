<?php
// App name
$clients_name = "Clients";

// Left
$lang["CLIENT_FOLDER"] = 'Folder';
$lang["CLIENT_FOLDER_NEW"] = 'New Folder';
$lang["CLIENT_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["CLIENT_CLIENTS"] = 'Clients';
$lang["CLIENT_NEW"] = 'New Client';
$lang["CLIENT_ACTION_NEW"] = 'new Client';

// Folder Right
$lang["CLIENT_FOLDER_CLIENTS_CREATED"] = 'Total Clients';
$lang["CLIENT_FOLDER_CLIENTS_PLANNED"] = 'planned';
$lang["CLIENT_FOLDER_CLIENTS_RUNNING"] = 'in progress';
$lang["CLIENT_FOLDER_CLIENTS_FINISHED"] = 'completed';
$lang["CLIENT_FOLDER_CLIENTS_STOPPED"] = 'stopped';
$lang["CLIENT_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["CLIENT_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["CLIENT_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["CLIENT_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["CLIENT_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["CLIENT_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["CLIENT_FOLDER_CHART_STATUS"] = 'Status';

// Client Right
$lang["CLIENT_TITLE"] = 'Client';
$lang['CLIENT_KICKOFF'] = 'Kick Off';

$lang["CLIENT_CLIENT"] = 'Authorised by';
$lang["CLIENT_MANAGEMENT"] = 'Client Manager';
$lang["CLIENT_TEAM"] = 'Client Team';
$lang["CLIENT_DESCRIPTION"] = 'Description';

$lang["CLIENT_STATUS_PLANNED"] = 'planned';
$lang["CLIENT_STATUS_INPROGRESS"] = 'started';
$lang["CLIENT_STATUS_FINISHED"] = 'completed';
$lang["CLIENT_STATUS_STOPPED"] = 'stopped';

$lang["CLIENT_STATUS_PLANNED_TEXT"] = 'planned';
$lang["CLIENT_STATUS_INPROGRESS_TEXT"] = 'started';
$lang["CLIENT_STATUS_FINISHED_TEXT"] = 'completed';
$lang["CLIENT_STATUS_STOPPED_TEXT"] = 'stopped';

$lang["CLIENT_HANDBOOK"] = 'Client Manual';

$lang["CLIENT_HELP"] = 'manual_kunden_kunden.pdf';
$lang["CLIENT_FOLDER_HELP"] = 'manual_kunden_ordner.pdf';

// Print images
$lang["PRINT_CLIENT_MANUAL"] = 'client_manual.png';
$lang["PRINT_CLIENT"] = 'client.png';
$lang["PRINT_CLIENT_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/clients/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>