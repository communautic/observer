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
$lang["EMPLOYEE_DESCRIPTION"] = 'Notiz';
$lang["EMPLOYEE_DOB"] = 'Geburtsdatum';
$lang["EMPLOYEE_COO"] = 'Nationalität';
$lang["EMPLOYEE_FAMILY_STATUS"] = 'Familienstand';
$lang["EMPLOYEE_CHILDREN"] = 'Kinder';
$lang["EMPLOYEE_LANGUAGES"] = 'Muttersprache';
$lang["EMPLOYEE_FOREIGN_LANGUAGES"] = 'Fremdsprachen';
$lang["EMPLOYEE_SKILLS"] = 'Kompetenz';


$lang["EMPLOYEE_PRIVATE_STREET"] = 'Strasse';
$lang["EMPLOYEE_PRIVATE_CITY"] = 'Ort';
$lang["EMPLOYEE_PRIVATE_ZIP"] = 'Plz';
$lang["EMPLOYEE_PRIVATE_PHONE"] = 'Telefon';
$lang["EMPLOYEE_PRIVATE_EMAIL"] = 'E-mail';

$lang["EMPLOYEE_EDUCATION"] = 'Schulbildung';
$lang["EMPLOYEE_EDUCATION_ADDITIONAL"] = 'Kompetenzaufbau';
$lang["EMPLOYEE_EXPERIENCE"] = 'Berufserfahrungen';
$lang["EMPLOYEE_EXPERIENCE_EXTERNAL"] = 'Zusatzausbildungen';

$lang["EMPLOYEE_HANDBOOK"] = 'Personalakt';

$lang["EMPLOYEE_HELP"] = 'manual_mitarbeiter_mitarbeiter.pdf';
$lang["EMPLOYEE_FOLDER_HELP"] = 'manual_mitarbeiter_ordner.pdf';

// Print images
$lang["PRINT_EMPLOYEE_MANUAL"] = 'personalakt.png';
$lang["PRINT_EMPLOYEE"] = 'mitarbeiter.png';
$lang["PRINT_EMPLOYEE_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/employees/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>