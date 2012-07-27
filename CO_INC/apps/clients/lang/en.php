<?php
// App name
$clients_name = "Clients";
$lang["clients_name"] = 'Kunden';

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
$lang["CLIENT_CONTRACT"] = 'Contract';

$lang["CLIENT_CONTRACT_ONE"] = 'Kindermenü ohne Suppe';
$lang["CLIENT_CONTRACT_TWO"] = 'Kindermenü mit Suppe';
$lang["CLIENT_CONTRACT_THREE"] = 'Erw. I ohne Suppe';
$lang["CLIENT_CONTRACT_FOUR"] = 'Erw. I mit Suppe';
$lang["CLIENT_CONTRACT_FIVE"] = 'Erw. II ohne Suppe';
$lang["CLIENT_CONTRACT_SIX"] = 'Erw. II mit Suppe';
$lang["CLIENT_CONTRACT_SEVEN"] = 'Erw. III ohne Suppe';
$lang["CLIENT_CONTRACT_EIGHT"] = 'Erw. IIII mit Suppe';


$lang["CLIENT_TEAM"] = 'Ansprechpartner';
$lang["CLIENT_ADDRESS"] = 'Lieferadresse';
$lang["CLIENT_BILLING_ADDRESS"] = 'Rechnungsadresse';

$lang["CLIENT_DESCRIPTION"] = 'Notizen';

$lang['CLIENTS_ACCESS_ACTIVE'] = 'Berechtigung erteilt am %s durch %s';

$lang["CLIENT_HANDBOOK"] = 'Projekthandbuch';


// Access codes Email
$lang['CLIENT_ACCESS_CODES_EMAIL_SUBJECT'] = 'mama-bringt\'s Bestellberechtigung';
$lang['CLIENT_ACCESS_CODES_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Hiermit erhalten Sie Ihre Zugangscodes zur erstmaligen Anmeldung für das Online-Bestellsystem von mama-bringt\'s ©:</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Internetadresse: <a href="%1$s">%1$s</a></p>' .
    							'<p style="font-face: Arial, Verdana; font-size: small">Benutzername: %2$s<br />' .
    							'Passwort: %3$s</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Bitte melden Sie sich an, indem Sie 1. die eingangs angegebene Internetadresse aufrufen und 2. die hier angegebenen Zugangsdaten (Benutzername und Passwort) eingeben und bestätigen. 3. Im Anschluss werden Sie aufgefordert, Ihre individuellen Zugangscodes zu kreieren. Mit diesen, neuen Zugangscodes erhalten Sie zukünftig Zugang zum Bestellservice auf www.mama-bringts.at</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Herzlichen Dank für die Zusammenarbeit, Ihr</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">mama-bringt\'s Team</p>';


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