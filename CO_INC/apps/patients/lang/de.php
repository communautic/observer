<?php
// App name
$patients_name = "Patienten";
$lang["patients_name"] = 'Patienten';

// Left
$lang["PATIENT_FOLDER"] = 'Ordner';
$lang["PATIENT_FOLDER_NEW"] = 'Neuer Ordner';
$lang["PATIENT_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["PATIENT_PATIENTS"] = 'Patient';
$lang["PATIENT_NEW"] = 'Neuer Patient';
$lang["PATIENT_ACTION_NEW"] = 'neuen Patienten anlegen';

// Folder Right
$lang["PATIENT_FOLDER_PATIENTS_CREATED"] = 'Patienten insgesamt';
$lang["PATIENT_FOLDER_PATIENTS_PLANNED"] = 'Patienten in Planung';
$lang["PATIENT_FOLDER_PATIENTS_RUNNING"] = 'Patienten in Arbeit';
$lang["PATIENT_FOLDER_PATIENTS_FINISHED"] = 'Patienten abgeschlossen';
$lang["PATIENT_FOLDER_PATIENTS_STOPPED"] = 'Patienten abgebrochen';
$lang["PATIENT_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["PATIENT_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["PATIENT_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["PATIENT_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["PATIENT_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["PATIENT_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["PATIENT_FOLDER_CHART_STATUS"] = 'Status';

// Patient Right
$lang["PATIENT_TITLE"] = 'Patient';
$lang['PATIENT_KICKOFF'] = 'Patienteneingang';

$lang["PATIENT_CONTACT_TITLE"] = 'Anrede';
$lang["PATIENT_CONTACT_TITLE2"] = 'Titel';
$lang["PATIENT_CONTACT_POSITION"] = 'Position';
$lang["PATIENT_CONTACT_PHONE"] = 'Telefon';
$lang["PATIENT_CONTACT_EMAIL"] = 'E-mail';

$lang["PATIENT_STARTDATE"] = 'Eintrittsdatum';
$lang["PATIENT_ENDDATE"] = 'Austrittsdatum';
$lang["PATIENT_NUMBER"] = 'Personalnummer';
$lang["PATIENT_KIND"] = 'Kondition';
$lang["PATIENT_AREA"] = 'Bereich';
$lang["PATIENT_DEPARTMENT"] = 'Abteilung';
$lang["PATIENT_DESCRIPTION"] = 'Historie';
$lang["PATIENT_DOB"] = 'Geburtsdatum';
$lang["PATIENT_COO"] = 'Nationalität';
$lang["PATIENT_LANGUAGES"] = 'Sprachkenntnisse';
$lang["PATIENT_SKILLS"] = 'Kompetenz';


$lang["PATIENT_PRIVATE_STREET"] = 'Strasse';
$lang["PATIENT_PRIVATE_CITY"] = 'Ort';
$lang["PATIENT_PRIVATE_ZIP"] = 'Plz';
$lang["PATIENT_PRIVATE_PHONE"] = 'Telefon';
$lang["PATIENT_PRIVATE_EMAIL"] = 'E-mail';

$lang["PATIENT_EDUCATION"] = 'Schulbildung';
$lang["PATIENT_EDUCATION_ADDITIONAL"] = 'Zusatzausbildungen';
$lang["PATIENT_EXPERIENCE"] = 'Berufserfahrung';

$lang["PATIENT_HANDBOOK"] = 'Personalakt';

$lang["PATIENT_HELP"] = 'manual_mitarbeiter_mitarbeiter.pdf';
$lang["PATIENT_FOLDER_HELP"] = 'manual_mitarbeiter_ordner.pdf';

// Print images
$lang["PRINT_PATIENT_MANUAL"] = 'personalakt.png';
$lang["PRINT_PATIENT"] = 'mitarbeiter.png';
$lang["PRINT_PATIENT_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/patients/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>