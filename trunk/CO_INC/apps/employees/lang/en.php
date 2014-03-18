<?php
// App name
$employees_name = "Employees";
$lang["employees_name"] = 'Employees';

// Left
$lang["EMPLOYEE_FOLDER"] = 'Folder';
$lang["EMPLOYEE_FOLDER_NEW"] = 'New Folder';
$lang["EMPLOYEE_FOLDER_ACTION_NEW"] = 'new Folder';
$lang["EMPLOYEE_EMPLOYEES"] = 'Employees';
$lang["EMPLOYEE_NEW"] = 'New Employee';
$lang["EMPLOYEE_ACTION_NEW"] = 'new Employee';

// Folder Right
$lang["EMPLOYEE_FOLDER_EMPLOYEES_CREATED"] = 'Total Employees';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_PLANNED"] = 'planned';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_RUNNING"] = 'in progress';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_FINISHED"] = 'completed';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_STOPPED"] = 'stopped';
$lang["EMPLOYEE_FOLDER_STATUS_ACTIVE"] = 'activ';
$lang["EMPLOYEE_FOLDER_STATUS_ARCHIVE"] = 'archive';

$lang["EMPLOYEE_FOLDER_CHART_STABILITY"] = 'Performance';
$lang["EMPLOYEE_FOLDER_CHART_REALISATION"] = 'Progress';
$lang["EMPLOYEE_FOLDER_CHART_ADHERANCE"] = 'Timeliness';
$lang["EMPLOYEE_FOLDER_CHART_TASKS"] = 'Stage Timeliness';
$lang["EMPLOYEE_FOLDER_CHART_STATUS"] = 'Status';

// Employee Right
$lang["EMPLOYEE_TITLE"] = 'Employee';
$lang['EMPLOYEE_KICKOFF'] = 'Kick Off';

$lang["EMPLOYEE_EMPLOYEE"] = 'Authorised by';
$lang["EMPLOYEE_MANAGEMENT"] = 'Employee Manager';
$lang["EMPLOYEE_CONTRACT"] = 'Contract';

$lang["EMPLOYEE_CONTRACT_ONE"] = 'Kindermenü ohne Suppe';
$lang["EMPLOYEE_CONTRACT_TWO"] = 'Kindermenü mit Suppe';
$lang["EMPLOYEE_CONTRACT_THREE"] = 'Erw. I ohne Suppe';
$lang["EMPLOYEE_CONTRACT_FOUR"] = 'Erw. I mit Suppe';
$lang["EMPLOYEE_CONTRACT_FIVE"] = 'Erw. II ohne Suppe';
$lang["EMPLOYEE_CONTRACT_SIX"] = 'Erw. II mit Suppe';
$lang["EMPLOYEE_CONTRACT_SEVEN"] = 'Erw. III ohne Suppe';
$lang["EMPLOYEE_CONTRACT_EIGHT"] = 'Erw. IIII mit Suppe';


$lang["EMPLOYEE_TEAM"] = 'Ansprechpartner';
$lang["EMPLOYEE_ADDRESS"] = 'Lieferadresse';
$lang["EMPLOYEE_BILLING_ADDRESS"] = 'Rechnungsadresse';

$lang["EMPLOYEE_DESCRIPTION"] = 'Notizen';

$lang['EMPLOYEES_ACCESS_ACTIVE'] = 'Berechtigung erteilt am %s durch %s';

$lang["EMPLOYEE_HANDBOOK"] = 'Projekthandbuch';


// Access codes Email
$lang['EMPLOYEE_ACCESS_CODES_EMAIL_SUBJECT'] = 'mama-bringt\'s Bestellberechtigung';
$lang['EMPLOYEE_ACCESS_CODES_EMAIL'] =	'<p style="font-face: Arial, Verdana; font-size: small">Hiermit erhalten Sie Ihre Zugangscodes zur erstmaligen Anmeldung für das Online-Bestellsystem von mama-bringt\'s ©:</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small">Internetadresse: <a href="%1$s">%1$s</a></p>' .
    							'<p style="font-face: Arial, Verdana; font-size: small">Benutzername: %2$s<br />' .
    							'Passwort: %3$s</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Bitte melden Sie sich an, indem Sie 1. die eingangs angegebene Internetadresse aufrufen und 2. die hier angegebenen Zugangsdaten (Benutzername und Passwort) eingeben und bestätigen. 3. Im Anschluss werden Sie aufgefordert, Ihre individuellen Zugangscodes zu kreieren. Mit diesen, neuen Zugangscodes erhalten Sie zukünftig Zugang zum Bestellservice auf www.mama-bringts.at</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">Herzlichen Dank für die Zusammenarbeit, Ihr</p>' .
								'<p style="font-face: Arial, Verdana; font-size: small;">mama-bringt\'s Team</p>';


$lang["EMPLOYEE_HELP"] = 'manual_kunden_kunden.pdf';
$lang["EMPLOYEE_FOLDER_HELP"] = 'manual_kunden_ordner.pdf';

// Print images
$lang["PRINT_EMPLOYEE_MANUAL"] = 'employee_manual.png';
$lang["PRINT_EMPLOYEE"] = 'employee.png';
$lang["PRINT_EMPLOYEE_FOLDER"] = 'folder.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/en.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>