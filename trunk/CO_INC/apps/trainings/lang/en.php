<?php
// App name
$trainings_name = "Trainings";
$lang["trainings_name"] = 'Trainings';

// Left
$lang["TRAINING_FOLDER"] = 'Folder';
$lang["TRAINING_FOLDER_NEW"] = 'New Folder';
$lang["TRAINING_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["TRAINING_TRAININGS"] = 'Trainings';
$lang["TRAINING_NEW"] = 'New Training';
$lang["TRAINING_ACTION_NEW"] = 'new Training';

// Folder Right
$lang["TRAINING_FOLDER_TRAININGS_CREATED"] = 'Total Trainings';
$lang["TRAINING_FOLDER_TRAININGS_PLANNED"] = 'planned';
$lang["TRAINING_FOLDER_TRAININGS_RUNNING"] = 'in progress';
$lang["TRAINING_FOLDER_TRAININGS_FINISHED"] = 'completed';
$lang["TRAINING_FOLDER_TRAININGS_STOPPED"] = 'stopped';
$lang["TRAINING_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["TRAINING_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["TRAINING_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["TRAINING_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["TRAINING_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["TRAINING_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["TRAINING_FOLDER_CHART_STATUS"] = 'Status';

// Training Right
$lang["TRAINING_TITLE"] = 'Training';
$lang['TRAINING_KICKOFF'] = 'Kick Off';

$lang["TRAINING_TRAINING"] = 'Authorised by';
$lang["TRAINING_MANAGEMENT"] = 'Training Manager';
$lang["TRAINING_CONTRACT"] = 'Contract';

$lang["TRAINING_CONTRACT_ONE"] = 'Kindermenü ohne Suppe';
$lang["TRAINING_CONTRACT_TWO"] = 'Kindermenü mit Suppe';
$lang["TRAINING_CONTRACT_THREE"] = 'Erw. I ohne Suppe';
$lang["TRAINING_CONTRACT_FOUR"] = 'Erw. I mit Suppe';
$lang["TRAINING_CONTRACT_FIVE"] = 'Erw. II ohne Suppe';
$lang["TRAINING_CONTRACT_SIX"] = 'Erw. II mit Suppe';
$lang["TRAINING_CONTRACT_SEVEN"] = 'Erw. III ohne Suppe';
$lang["TRAINING_CONTRACT_EIGHT"] = 'Erw. IIII mit Suppe';


$lang["TRAINING_TEAM"] = 'Ansprechpartner';
$lang["TRAINING_ADDRESS"] = 'Lieferadresse';
$lang["TRAINING_BILLING_ADDRESS"] = 'Rechnungsadresse';

$lang["TRAINING_DESCRIPTION"] = 'Notizen';

$lang['TRAININGS_ACCESS_ACTIVE'] = 'Berechtigung erteilt am %s durch %s';

$lang["TRAINING_HANDBOOK"] = 'Projekthandbuch';


// Access codes Email
$lang['TRAINING_ACCESS_CODES_EMAIL_SUBJECT'] = 'mama-bringt\'s Bestellberechtigung';
$lang['TRAINING_ACCESS_CODES_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Hiermit erhalten Sie Ihre Zugangscodes zur erstmaligen Anmeldung für das Online-Bestellsystem von mama-bringt\'s ©:</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Internetadresse: <a href="%1$s">%1$s</a></p>' .
    							'<p style="font-face: Arial, Verdana; font-size: small">Benutzername: %2$s<br />' .
    							'Passwort: %3$s</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Bitte melden Sie sich an, indem Sie 1. die eingangs angegebene Internetadresse aufrufen und 2. die hier angegebenen Zugangsdaten (Benutzername und Passwort) eingeben und bestätigen. 3. Im Anschluss werden Sie aufgefordert, Ihre individuellen Zugangscodes zu kreieren. Mit diesen, neuen Zugangscodes erhalten Sie zukünftig Zugang zum Bestellservice auf www.mama-bringts.at</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Herzlichen Dank für die Zusammenarbeit, Ihr</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">mama-bringt\'s Team</p>';


$lang["TRAINING_HELP"] = 'manual_kunden_kunden.pdf';
$lang["TRAINING_FOLDER_HELP"] = 'manual_kunden_ordner.pdf';

// Print images
$lang["PRINT_TRAINING_MANUAL"] = 'training_manual.png';
$lang["PRINT_TRAINING"] = 'training.png';
$lang["PRINT_TRAINING_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/trainings/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>