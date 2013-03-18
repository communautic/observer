<?php
// App name
$complaints_name = "Reklamationen";
$lang["complaints_name"] = 'Reklamationen';

// Left
$lang["COMPLAINT_FOLDER"] = 'Ordner';
$lang["COMPLAINT_FOLDER_NEW"] = 'Neuer Ordner';
$lang["COMPLAINT_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["COMPLAINT_COMPLAINTS"] = 'Reklamationen';
$lang["COMPLAINT_NEW"] = 'Neue Reklamation';
$lang["COMPLAINT_ACTION_NEW"] = 'neue Reklamation anlegen';

// Folder Right
$lang["COMPLAINT_FOLDER_COMPLAINTS_CREATED"] = 'Reklamationen insgesamt';
$lang["COMPLAINT_FOLDER_COMPLAINTS_PLANNED"] = 'Reklamationen in Planung';
$lang["COMPLAINT_FOLDER_COMPLAINTS_RUNNING"] = 'Reklamationen in Arbeit';
$lang["COMPLAINT_FOLDER_COMPLAINTS_FINISHED"] = 'Reklamationen abgeschlossen';
$lang["COMPLAINT_FOLDER_COMPLAINTS_STOPPED"] = 'Reklamationen abgebrochen';
$lang["COMPLAINT_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["COMPLAINT_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["COMPLAINT_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["COMPLAINT_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["COMPLAINT_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["COMPLAINT_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["COMPLAINT_FOLDER_CHART_STATUS"] = 'Status';

// Complaint Right
$lang["COMPLAINT_TITLE"] = 'Reklamation';
$lang['COMPLAINT_KICKOFF'] = 'Reklamationseingang';

$lang["COMPLAINT_CLIENT"] = 'Reklamant';
$lang["COMPLAINT_MANAGEMENT"] = 'Lösungsverantwortung';
$lang["COMPLAINT_TEAM"] = 'Lösungsteam';
$lang["COMPLAINT_COMPLAINTCAT"] = 'Reklamationsart';
$lang["COMPLAINT_COMPLAINTCATMORE"] = 'Reklamationsquelle';
$lang["COMPLAINT_CAT"] = 'Mangelkategorie';
$lang["COMPLAINT_CAT_MORE"] = 'Reklamationsmuster';
$lang["COMPLAINT_PRODUCT_NUMBER"] = 'Produktnummer';
$lang["COMPLAINT_PRODUCT"] = 'Produktbezeichnung';
$lang["COMPLAINT_CHARGE"] = 'Charge';
$lang["COMPLAINT_NUMBER"] = 'Menge';
$lang["COMPLAINT_DESCRIPTION"] = 'Notiz';

$lang["COMPLAINT_HELP"] = 'manual_reklamationen_reklamationen.pdf';
$lang["COMPLAINT_FOLDER_HELP"] = 'manual_reklamationen_ordner.pdf';

// Print images
$lang["PRINT_COMPLAINT"] = 'reklamation.png';
$lang["PRINT_COMPLAINT_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>