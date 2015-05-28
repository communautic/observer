<?php
// App name
$evals_name = "performeval &copy;";
$lang["evals_name"] = 'performeval';

// Left
$lang["EVAL_FOLDER"] = 'Ordner';
$lang["EVAL_FOLDER_NEW"] = 'Neuer Ordner';
$lang["EVAL_FOLDER_ACTION_NEW"] = 'neuen Ordner anlegen';
$lang["EVAL_EVALS"] = 'Teilnehmer';
$lang["EVAL_NEW"] = 'Neuer Teilnehmer';
$lang["EVAL_ACTION_NEW"] = 'neuen Teilnehmer anlegen';

// Folder Right
$lang["EVAL_FOLDER_EVALS_CREATED"] = 'Mitarbeiter insgesamt';
$lang["EVAL_FOLDER_EVALS_PLANNED"] = 'Mitarbeiter in Planung';
$lang["EVAL_FOLDER_EVALS_RUNNING"] = 'Mitarbeiter in Arbeit';
$lang["EVAL_FOLDER_EVALS_FINISHED"] = 'Mitarbeiter abgeschlossen';
$lang["EVAL_FOLDER_EVALS_STOPPED"] = 'Mitarbeiter abgebrochen';
$lang["EVAL_FOLDER_STATUS_ACTIVE"] = 'aktiv';
$lang["EVAL_FOLDER_STATUS_ARCHIVE"] = 'archiv';

$lang["EVAL_FOLDER_CHART_STABILITY"] = 'Projektstabilität aktuell';
$lang["EVAL_FOLDER_CHART_REALISATION"] = 'Realisierungsgrad';
$lang["EVAL_FOLDER_CHART_ADHERANCE"] = 'Termintreue';
$lang["EVAL_FOLDER_CHART_TASKS"] = 'Arbeitspakete in Plan';
$lang["EVAL_FOLDER_CHART_STATUS"] = 'Status';

// Eval Right
$lang["EVAL_TITLE"] = 'Mitarbeiter';
$lang['EVAL_KICKOFF'] = 'Mitarbeitereingang';

$lang["EVAL_CONTACT_TITLE"] = 'Anrede';
$lang["EVAL_CONTACT_TITLE2"] = 'Titel';
$lang["EVAL_CONTACT_POSITION"] = 'Position';
$lang["EVAL_CONTACT_PHONE"] = 'Telefon';
$lang["EVAL_CONTACT_EMAIL"] = 'E-mail';

$lang["EVAL_STARTDATE"] = 'Erstanalyse';
$lang["EVAL_ENDDATE"] = 'Austrittsdatum';
$lang["EVAL_NUMBER"] = 'Personalnummer';
$lang["EVAL_KIND"] = 'Kondition';
$lang["EVAL_AREA"] = 'Bereich';
$lang["EVAL_DEPARTMENT"] = 'Abteilung';
$lang["EVAL_DESCRIPTION"] = 'Notiz';
$lang["EVAL_DOB"] = 'Geburtsdatum';
$lang["EVAL_COO"] = 'Nationalität';
$lang["EVAL_FAMILY_STATUS"] = 'Familienstand';
$lang["EVAL_CHILDREN"] = 'Kinder';
$lang["EVAL_LANGUAGES"] = 'Muttersprache';
$lang["EVAL_FOREIGN_LANGUAGES"] = 'Fremdsprachen';
$lang["EVAL_SKILLS"] = 'Kompetenz';


$lang["EVAL_PRIVATE_STREET"] = 'Strasse';
$lang["EVAL_PRIVATE_CITY"] = 'Ort';
$lang["EVAL_PRIVATE_ZIP"] = 'Plz';
$lang["EVAL_PRIVATE_PHONE"] = 'Telefon';
$lang["EVAL_PRIVATE_EMAIL"] = 'E-mail';

$lang["EVAL_EDUCATION"] = 'Schulbildung';
$lang["EVAL_EDUCATION_ADDITIONAL"] = 'Berufserfahrung intern';
$lang["EVAL_EXPERIENCE"] = 'Berufserfahrung extern';
$lang["EVAL_EXPERIENCE_EXTERNAL"] = 'Zusatzausbildungen';

$lang["EVAL_HANDBOOK"] = 'Personalakt';

$lang["EVAL_HELP"] = 'manual_mitarbeiter_mitarbeiter.pdf';
$lang["EVAL_FOLDER_HELP"] = 'manual_mitarbeiter_ordner.pdf';

// Print images
$lang["PRINT_EVAL_MANUAL"] = 'personalakt.png';
$lang["PRINT_EVAL"] = 'mitarbeiter.png';
$lang["PRINT_EVAL_FOLDER"] = 'ordner.png';


// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/evals/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>