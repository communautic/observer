<?php
// App name
$evals_name = "Evals";
$lang["evals_name"] = 'Evals';

// Left
$lang["EVAL_FOLDER"] = 'Folder';
$lang["EVAL_FOLDER_NEW"] = 'New Folder';
$lang["EVAL_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["EVAL_EVALS"] = 'Evals';
$lang["EVAL_NEW"] = 'New Eval';
$lang["EVAL_ACTION_NEW"] = 'new Eval';

// Folder Right
$lang["EVAL_FOLDER_EVALS_CREATED"] = 'Total Evals';
$lang["EVAL_FOLDER_EVALS_PLANNED"] = 'planned';
$lang["EVAL_FOLDER_EVALS_RUNNING"] = 'in progress';
$lang["EVAL_FOLDER_EVALS_FINISHED"] = 'completed';
$lang["EVAL_FOLDER_EVALS_STOPPED"] = 'stopped';
$lang["EVAL_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["EVAL_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["EVAL_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["EVAL_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["EVAL_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["EVAL_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["EVAL_FOLDER_CHART_STATUS"] = 'Status';

// Eval Right
$lang["EVAL_TITLE"] = 'Eval';
$lang['EVAL_KICKOFF'] = 'Kick Off';

$lang["EVAL_EVAL"] = 'Authorised by';
$lang["EVAL_MANAGEMENT"] = 'Eval Manager';
$lang["EVAL_CONTRACT"] = 'Contract';

$lang["EVAL_CONTRACT_ONE"] = 'Kindermenü ohne Suppe';
$lang["EVAL_CONTRACT_TWO"] = 'Kindermenü mit Suppe';
$lang["EVAL_CONTRACT_THREE"] = 'Erw. I ohne Suppe';
$lang["EVAL_CONTRACT_FOUR"] = 'Erw. I mit Suppe';
$lang["EVAL_CONTRACT_FIVE"] = 'Erw. II ohne Suppe';
$lang["EVAL_CONTRACT_SIX"] = 'Erw. II mit Suppe';
$lang["EVAL_CONTRACT_SEVEN"] = 'Erw. III ohne Suppe';
$lang["EVAL_CONTRACT_EIGHT"] = 'Erw. IIII mit Suppe';


$lang["EVAL_TEAM"] = 'Ansprechpartner';
$lang["EVAL_ADDRESS"] = 'Lieferadresse';
$lang["EVAL_BILLING_ADDRESS"] = 'Rechnungsadresse';

$lang["EVAL_DESCRIPTION"] = 'Notizen';

$lang['EVALS_ACCESS_ACTIVE'] = 'Berechtigung erteilt am %s durch %s';

$lang["EVAL_HANDBOOK"] = 'Projekthandbuch';


// Access codes Email
$lang['EVAL_ACCESS_CODES_EMAIL_SUBJECT'] = 'mama-bringt\'s Bestellberechtigung';
$lang['EVAL_ACCESS_CODES_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Hiermit erhalten Sie Ihre Zugangscodes zur erstmaligen Anmeldung für das Online-Bestellsystem von mama-bringt\'s ©:</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Internetadresse: <a href="%1$s">%1$s</a></p>' .
    							'<p style="font-face: Arial, Verdana; font-size: small">Benutzername: %2$s<br />' .
    							'Passwort: %3$s</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Bitte melden Sie sich an, indem Sie 1. die eingangs angegebene Internetadresse aufrufen und 2. die hier angegebenen Zugangsdaten (Benutzername und Passwort) eingeben und bestätigen. 3. Im Anschluss werden Sie aufgefordert, Ihre individuellen Zugangscodes zu kreieren. Mit diesen, neuen Zugangscodes erhalten Sie zukünftig Zugang zum Bestellservice auf www.mama-bringts.at</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Herzlichen Dank für die Zusammenarbeit, Ihr</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">mama-bringt\'s Team</p>';


$lang["EVAL_HELP"] = 'manual_kunden_kunden.pdf';
$lang["EVAL_FOLDER_HELP"] = 'manual_kunden_ordner.pdf';

// Print images
$lang["PRINT_EVAL_MANUAL"] = 'eval_manual.png';
$lang["PRINT_EVAL"] = 'eval.png';
$lang["PRINT_EVAL_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>