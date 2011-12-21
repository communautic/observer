<?php
$publishers_menues_name = "Speisekarten";

$lang["PUBLISHER_MENUE_TITLE"] = 'Speisekarte';
$lang["PUBLISHER_MENUES"] = 'Speisekarten';

$lang["PUBLISHER_MENUE_NEW"] = 'Neue Speisekarte';
$lang["PUBLISHER_MENUE_ACTION_NEW"] = 'neue Speisekarte anlegen';

$lang["PUBLISHER_MENUE_DATE_FROM"] = 'gültig von';
$lang["PUBLISHER_MENUE_DATE_TO"] = 'gültig bis';

$lang["PUBLISHER_MENUE_MANAGEMENT"] = 'Menüverantwortung';
$lang["PUBLISHER_MENUE_GOALS"] = 'Beschreibung';

$lang["PUBLISHER_MENUE_STATUS_PLANNED"] = 'in Planung seit';
$lang["PUBLISHER_MENUE_STATUS_PUBLISHED"] = 'publiziert seit';
$lang["PUBLISHER_MENUE_STATUS_ARCHIVED"] = 'archiviert seit';

$lang["PUBLISHER_MENUE_HELP"] = 'manual_projekte_telefonate.pdf';

$lang["PUBLISHER_PRINT_MENUE"] = 'telefonat.png';

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/publishers/menues/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>