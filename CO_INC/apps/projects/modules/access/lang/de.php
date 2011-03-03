<?php
$access_name = "Zugangsberechtigungen";

// Right
define('ACCESS_TITLE', 'Kontakt:');
define('ACCESS_LEVEL', 'Zugangsart:');
define('ACCESS_LEVEL_GUEST', 'Beobachter');
define('ACCESS_LEVEL_ADMIN', 'Administrator');
define('ACCESS_NEWSCIRCLE', 'Newscircle:');
define('ACCESS_CONTACTS', 'Kontakte:');

// check for custom lang file
$custom_lang = CO_PATH_BASE . "/lang/projects/access/de.php";
if(file_exists($custom_lang)) {
	include_once($custom_lang);
}
?>