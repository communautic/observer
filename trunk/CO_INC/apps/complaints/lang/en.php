<?php
// App name
$complaints_name = "Complaints";

// Left
$lang["COMPLAINT_FOLDER"] = 'Folder';
$lang["COMPLAINT_FOLDER_NEW"] = 'New Folder';
$lang["COMPLAINT_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["COMPLAINT_COMPLAINTS"] = 'Complaints';
$lang["COMPLAINT_NEW"] = 'New Complaint';
$lang["COMPLAINT_ACTION_NEW"] = 'new Complaint';

// Folder Right
$lang["COMPLAINT_FOLDER_COMPLAINTS_CREATED"] = 'Total Complaints';
$lang["COMPLAINT_FOLDER_COMPLAINTS_PLANNED"] = 'planned';
$lang["COMPLAINT_FOLDER_COMPLAINTS_RUNNING"] = 'in progress';
$lang["COMPLAINT_FOLDER_COMPLAINTS_FINISHED"] = 'completed';
$lang["COMPLAINT_FOLDER_COMPLAINTS_STOPPED"] = 'stopped';
$lang["COMPLAINT_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["COMPLAINT_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["COMPLAINT_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["COMPLAINT_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["COMPLAINT_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["COMPLAINT_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["COMPLAINT_FOLDER_CHART_STATUS"] = 'Status';

// Complaint Right
$lang["COMPLAINT_TITLE"] = 'Complaint';
$lang['COMPLAINT_KICKOFF'] = 'Kick Off';

$lang["COMPLAINT_COMPLAINT"] = 'Authorised by';
$lang["COMPLAINT_MANAGEMENT"] = 'Complaint Manager';
$lang["COMPLAINT_CONTRACT"] = 'Contract';

$lang["COMPLAINT_CONTRACT_ONE"] = 'Kindermenü ohne Suppe';
$lang["COMPLAINT_CONTRACT_TWO"] = 'Kindermenü mit Suppe';
$lang["COMPLAINT_CONTRACT_THREE"] = 'Erw. I ohne Suppe';
$lang["COMPLAINT_CONTRACT_FOUR"] = 'Erw. I mit Suppe';
$lang["COMPLAINT_CONTRACT_FIVE"] = 'Erw. II ohne Suppe';
$lang["COMPLAINT_CONTRACT_SIX"] = 'Erw. II mit Suppe';
$lang["COMPLAINT_CONTRACT_SEVEN"] = 'Erw. III ohne Suppe';
$lang["COMPLAINT_CONTRACT_EIGHT"] = 'Erw. IIII mit Suppe';


$lang["COMPLAINT_TEAM"] = 'Ansprechpartner';
$lang["COMPLAINT_ADDRESS"] = 'Lieferadresse';
$lang["COMPLAINT_BILLING_ADDRESS"] = 'Rechnungsadresse';

$lang["COMPLAINT_DESCRIPTION"] = 'Notizen';

$lang['COMPLAINTS_ACCESS_ACTIVE'] = 'Berechtigung erteilt am %s durch %s';

$lang["COMPLAINT_STATUS_PLANNED"] = 'planned';
$lang["COMPLAINT_STATUS_INPROGRESS"] = 'started';
$lang["COMPLAINT_STATUS_FINISHED"] = 'completed';
$lang["COMPLAINT_STATUS_STOPPED"] = 'stopped';

$lang["COMPLAINT_STATUS_PLANNED_TEXT"] = 'planned';
$lang["COMPLAINT_STATUS_INPROGRESS_TEXT"] = 'started';
$lang["COMPLAINT_STATUS_FINISHED_TEXT"] = 'completed';
$lang["COMPLAINT_STATUS_STOPPED_TEXT"] = 'stopped';
$lang["COMPLAINT_HANDBOOK"] = 'Projekthandbuch';


// Access codes Email
$lang['COMPLAINT_ACCESS_CODES_EMAIL_SUBJECT'] = 'mama-bringt\'s Bestellberechtigung';
$lang['COMPLAINT_ACCESS_CODES_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Hiermit erhalten Sie Ihre Zugangscodes zur erstmaligen Anmeldung für das Online-Bestellsystem von mama-bringt\'s ©:</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Internetadresse: <a href="%1$s">%1$s</a></p>' .
    							'<p style="font-face: Arial, Verdana; font-size: small">Benutzername: %2$s<br />' .
    							'Passwort: %3$s</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Bitte melden Sie sich an, indem Sie 1. die eingangs angegebene Internetadresse aufrufen und 2. die hier angegebenen Zugangsdaten (Benutzername und Passwort) eingeben und bestätigen. 3. Im Anschluss werden Sie aufgefordert, Ihre individuellen Zugangscodes zu kreieren. Mit diesen, neuen Zugangscodes erhalten Sie zukünftig Zugang zum Bestellservice auf www.mama-bringts.at</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Herzlichen Dank für die Zusammenarbeit, Ihr</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">mama-bringt\'s Team</p>';


$lang["COMPLAINT_HELP"] = 'manual_kunden_kunden.pdf';
$lang["COMPLAINT_FOLDER_HELP"] = 'manual_kunden_ordner.pdf';

// Print images
$lang["PRINT_COMPLAINT_MANUAL"] = 'complaint_manual.png';
$lang["PRINT_COMPLAINT"] = 'complaint.png';
$lang["PRINT_COMPLAINT_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/complaints/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>