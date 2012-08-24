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

$lang["EMPLOYEE_CONTACT_TITLE"] = 'Anrede';
$lang["EMPLOYEE_CONTACT_TITLE2"] = 'Titel';
$lang["EMPLOYEE_CONTACT_POSITION"] = 'Position';
$lang["EMPLOYEE_CONTACT_PHONE"] = 'Telefon';
$lang["EMPLOYEE_CONTACT_EMAIL"] = 'E-mail';

$lang["EMPLOYEE_STARTDATE"] = 'Eintrittsdatum';
$lang["EMPLOYEE_ENDDATE"] = 'Austrittsdatum';
$lang["EMPLOYEE_NUMBER"] = 'Personalnummer';
$lang["EMPLOYEE_KIND"] = 'Kondition';
$lang["EMPLOYEE_AREA"] = 'Bereich';
$lang["EMPLOYEE_DEPARTMENT"] = 'Abteilung';
$lang["EMPLOYEE_DESCRIPTION"] = 'Historie';
$lang["EMPLOYEE_DOB"] = 'Geburtsdatum';
$lang["EMPLOYEE_COO"] = 'Nationalität';
$lang["EMPLOYEE_LANGUAGES"] = 'Sprachkenntnisse';
$lang["EMPLOYEE_SKILLS"] = 'Kompetenz';


$lang["EMPLOYEE_PRIVATE_STREET"] = 'Strasse';
$lang["EMPLOYEE_PRIVATE_CITY"] = 'Ort';
$lang["EMPLOYEE_PRIVATE_ZIP"] = 'Plz';
$lang["EMPLOYEE_PRIVATE_PHONE"] = 'Telefon';
$lang["EMPLOYEE_PRIVATE_EMAIL"] = 'E-mail';

$lang["EMPLOYEE_COSTS_TOTAL"] = 'Gesamtgehalt (€)';
$lang["EMPLOYEE_COSTS_BRUTTO"] = 'Bruttogehalt (€)';
$lang["EMPLOYEE_COSTS_NETTO"] = 'Nettogehalt (€)';
$lang["EMPLOYEE_COSTS_KV"] = 'KV Stufe';
$lang["EMPLOYEE_COSTS_ADDONS"] = 'Zulagen (€)';
$lang["EMPLOYEE_COSTS_OVERTIME"] = 'Überstungen (€)';
$lang["EMPLOYEE_COSTS_WORKHOURS"] = 'Arbeitszeit (Std.)';

$lang["EMPLOYEE_HANDBOOK"] = 'Personalakt';

$lang["EMPLOYEE_HELP"] = 'manual_mitarbeiter_mitarbeiter.pdf';
$lang["EMPLOYEE_FOLDER_HELP"] = 'manual_mitarbeiter_ordner.pdf';

// Print images
$lang["PRINT_EMPLOYEE"] = 'reklamation.png';
$lang["PRINT_EMPLOYEE_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>