<?php
// App name
$patients_name = "Patients";
$lang["patients_name"] = 'Patients';

// Left
$lang["PATIENT_FOLDER"] = 'Folder';
$lang["PATIENT_FOLDER_NEW"] = 'New Folder';
$lang["PATIENT_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["PATIENT_PATIENTS"] = 'Patients';
$lang["PATIENT_NEW"] = 'New Patient';
$lang["PATIENT_ACTION_NEW"] = 'new Patient';

// Folder Right
$lang["PATIENT_FOLDER_PATIENTS_CREATED"] = 'Total Patients';
$lang["PATIENT_FOLDER_PATIENTS_PLANNED"] = 'planned';
$lang["PATIENT_FOLDER_PATIENTS_RUNNING"] = 'in progress';
$lang["PATIENT_FOLDER_PATIENTS_FINISHED"] = 'completed';
$lang["PATIENT_FOLDER_PATIENTS_STOPPED"] = 'stopped';
$lang["PATIENT_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["PATIENT_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["PATIENT_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["PATIENT_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["PATIENT_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["PATIENT_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["PATIENT_FOLDER_CHART_STATUS"] = 'Status';

// Patient Right
$lang["PATIENT_TITLE"] = 'Patient';
$lang['PATIENT_KICKOFF'] = 'Kick Off';

$lang["PATIENT_PATIENT"] = 'Authorised by';
$lang["PATIENT_MANAGEMENT"] = 'Patient Manager';
$lang["PATIENT_CONTRACT"] = 'Contract';

$lang["PATIENT_CONTRACT_ONE"] = 'Kindermenü ohne Suppe';
$lang["PATIENT_CONTRACT_TWO"] = 'Kindermenü mit Suppe';
$lang["PATIENT_CONTRACT_THREE"] = 'Erw. I ohne Suppe';
$lang["PATIENT_CONTRACT_FOUR"] = 'Erw. I mit Suppe';
$lang["PATIENT_CONTRACT_FIVE"] = 'Erw. II ohne Suppe';
$lang["PATIENT_CONTRACT_SIX"] = 'Erw. II mit Suppe';
$lang["PATIENT_CONTRACT_SEVEN"] = 'Erw. III ohne Suppe';
$lang["PATIENT_CONTRACT_EIGHT"] = 'Erw. IIII mit Suppe';


$lang["PATIENT_TEAM"] = 'Ansprechpartner';
$lang["PATIENT_ADDRESS"] = 'Lieferadresse';
$lang["PATIENT_BILLING_ADDRESS"] = 'Rechnungsadresse';

$lang["PATIENT_DESCRIPTION"] = 'Notizen';

$lang['PATIENTS_ACCESS_ACTIVE'] = 'Berechtigung erteilt am %s durch %s';

$lang["PATIENT_HANDBOOK"] = 'Projekthandbuch';


// Access codes Email
$lang['PATIENT_ACCESS_CODES_EMAIL_SUBJECT'] = 'mama-bringt\'s Bestellberechtigung';
$lang['PATIENT_ACCESS_CODES_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Hiermit erhalten Sie Ihre Zugangscodes zur erstmaligen Anmeldung für das Online-Bestellsystem von mama-bringt\'s ©:</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Internetadresse: <a href="%1$s">%1$s</a></p>' .
    							'<p style="font-face: Arial, Verdana; font-size: small">Benutzername: %2$s<br />' .
    							'Passwort: %3$s</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Bitte melden Sie sich an, indem Sie 1. die eingangs angegebene Internetadresse aufrufen und 2. die hier angegebenen Zugangsdaten (Benutzername und Passwort) eingeben und bestätigen. 3. Im Anschluss werden Sie aufgefordert, Ihre individuellen Zugangscodes zu kreieren. Mit diesen, neuen Zugangscodes erhalten Sie zukünftig Zugang zum Bestellservice auf www.mama-bringts.at</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Herzlichen Dank für die Zusammenarbeit, Ihr</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">mama-bringt\'s Team</p>';


$lang["PATIENT_HELP"] = 'manual_kunden_kunden.pdf';
$lang["PATIENT_FOLDER_HELP"] = 'manual_kunden_ordner.pdf';

// Print images
$lang["PRINT_PATIENT_MANUAL"] = 'patient_manual.png';
$lang["PRINT_PATIENT"] = 'patient.png';
$lang["PRINT_PATIENT_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>