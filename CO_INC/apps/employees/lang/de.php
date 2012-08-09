<?php
// App name
$employees_name = "Mitarbeiter";
$lang["employees_name"] = 'Mitarbeiter';

// Left
$lang["EMPLOYEE_FOLDER"] = 'Ordner';
$lang["EMPLOYEE_FOLDER_NEW"] = 'Neuer Ordner';
$lang["EMPLOYEE_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["EMPLOYEE_EMPLOYEES"] = 'Mitarbeiter';
$lang["EMPLOYEE_NEW"] = 'Neuer Mitarbeiter';
$lang["EMPLOYEE_ACTION_NEW"] = 'neuen Mitarbeiter anlegen';

// Folder Right
$lang["EMPLOYEE_FOLDER_EMPLOYEES_CREATED"] = 'Mitarbeiter insgesamt';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_PLANNED"] = 'Mitarbeiter in Planung';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_RUNNING"] = 'Mitarbeiter in Arbeit';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_FINISHED"] = 'Mitarbeiter abgeschlossen';
$lang["EMPLOYEE_FOLDER_EMPLOYEES_STOPPED"] = 'Mitarbeiter abgebrochen';
$lang["EMPLOYEE_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["EMPLOYEE_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["EMPLOYEE_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["EMPLOYEE_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["EMPLOYEE_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["EMPLOYEE_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["EMPLOYEE_FOLDER_CHART_STATUS"] = 'Status';

// Employee Right
$lang["EMPLOYEE_TITLE"] = 'Mitarbeiter';
$lang['EMPLOYEE_KICKOFF'] = 'Mitarbeitereingang';

$lang["EMPLOYEE_CLIENT"] = 'Reklamant';
$lang["EMPLOYEE_MANAGEMENT"] = 'Lösungsverantwortung';
$lang["EMPLOYEE_TEAM"] = 'Lösungsteam';
$lang["EMPLOYEE_EMPLOYEECAT"] = 'Reklamationsart';
$lang["EMPLOYEE_EMPLOYEECATMORE"] = 'Reklamationsquelle';
$lang["EMPLOYEE_CAT"] = 'Mangelkategorie';
$lang["EMPLOYEE_CAT_MORE"] = 'Reklamationsmuster';
$lang["EMPLOYEE_PRODUCT_NUMBER"] = 'Produktnummer';
$lang["EMPLOYEE_PRODUCT"] = 'Produktbezeichnung';
$lang["EMPLOYEE_CHARGE"] = 'Charge';
$lang["EMPLOYEE_NUMBER"] = 'Menge';
$lang["EMPLOYEE_DESCRIPTION"] = 'Notiz';

$lang["EMPLOYEE_HELP"] = 'manual_reklamationen_reklamationen.pdf';
$lang["EMPLOYEE_FOLDER_HELP"] = 'manual_reklamationen_ordner.pdf';

// Print images
$lang["PRINT_EMPLOYEE"] = 'reklamation.png';
$lang["PRINT_EMPLOYEE_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>