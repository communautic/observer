<?php
// App name
$publishers_name = "Publishers";

// Left
$lang["PUBLISHER_FOLDER"] = 'Folder';
$lang["PUBLISHER_FOLDER_NEW"] = 'New Folder';
$lang["PUBLISHER_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["PUBLISHER_PUBLISHERS"] = 'Publishers';
$lang["PUBLISHER_NEW"] = 'New Publisher';
$lang["PUBLISHER_ACTION_NEW"] = 'new Publisher';

// Folder Right
$lang["PUBLISHER_FOLDER_PUBLISHERS_CREATED"] = 'Total Publishers';
$lang["PUBLISHER_FOLDER_PUBLISHERS_PLANNED"] = 'planned';
$lang["PUBLISHER_FOLDER_PUBLISHERS_RUNNING"] = 'in progress';
$lang["PUBLISHER_FOLDER_PUBLISHERS_FINISHED"] = 'completed';
$lang["PUBLISHER_FOLDER_PUBLISHERS_STOPPED"] = 'stopped';
$lang["PUBLISHER_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["PUBLISHER_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["PUBLISHER_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["PUBLISHER_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["PUBLISHER_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["PUBLISHER_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["PUBLISHER_FOLDER_CHART_STATUS"] = 'Status';

// Publisher Right
$lang["PUBLISHER_TITLE"] = 'Publisher';
$lang['PUBLISHER_KICKOFF'] = 'Kick Off';

$lang["PUBLISHER_CLIENT"] = 'Authorised by';
$lang["PUBLISHER_MANAGEMENT"] = 'Publisher Manager';
$lang["PUBLISHER_TEAM"] = 'Publisher Team';
$lang["PUBLISHER_DESCRIPTION"] = 'Description';

$lang["PUBLISHER_STATUS_PLANNED"] = 'planned';
$lang["PUBLISHER_STATUS_INPROGRESS"] = 'started';
$lang["PUBLISHER_STATUS_FINISHED"] = 'completed';
$lang["PUBLISHER_STATUS_STOPPED"] = 'stopped';

$lang["PUBLISHER_STATUS_PLANNED_TEXT"] = 'planned';
$lang["PUBLISHER_STATUS_INPROGRESS_TEXT"] = 'started';
$lang["PUBLISHER_STATUS_FINISHED_TEXT"] = 'completed';
$lang["PUBLISHER_STATUS_STOPPED_TEXT"] = 'stopped';

$lang["PUBLISHER_HANDBOOK"] = 'Publisher Manual';

$lang["PUBLISHER_HELP"] = 'manual_projekte_projekte.pdf';
$lang["PUBLISHER_FOLDER_HELP"] = 'manual_projekte_ordner.pdf';

// Print images
$lang["PRINT_PUBLISHER_MANUAL"] = 'publisher_manual.png';
$lang["PRINT_PUBLISHER"] = 'publisher.png';
$lang["PRINT_PUBLISHER_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/publishers/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>