<?php
/* LOGIN PAGE */
define('LOGIN_USERNAME', 'Username:');
define('LOGIN_PASSWORD', 'Password:');
define('LOGIN_REMEMBER', 'Remember me on this computer');
define('LOGIN_REQUIREMENTS', 'System requirements');
define('LOGIN_REQUIREMENTS_DETAILS', 'Internet Explorer 6+, Firefox 2+, Safari3+');
define('LOGIN_LOGIN', 'login');
define('LOGIN_COPYRIGHT', '<a href="http://www.communautic.com" target="_blank">All rights reserved communautic Ebenbichler KG | www.communautic.com</a>');
define('LOGIN_LOGIN_FAILED', 'Incorrect login details. Please try again');
define('LOGIN_LOGOUT', 'Logout');

define('TEXT_SAVING', 'Saving data ...');

/* APPS ACTION LINKS */
define('ACTION_NEW', 'new');
define('ACTION_SAVE', 'save');
define('ACTION_PRINT', 'print');
define('ACTION_SENDTO', 'send to');
define('ACTION_DUPLICATE', 'duplicate');
define('ACTION_DELETE', 'delete');

/***************************
* GLOBAL LANGUAGE SETTINGS *
****************************/
// Startseite
define('APPLICATION_NAME', 'company observer 6.1');
define('MAIN_LOGO', 'projektbeobachter_logo.jpg');
define('START_LIZENZ', '');
define('START_SLOGAN', 'startslogan_de.jpg');
define('COMPANY_LOGO', 'firmenlogo.jpg');
define('COMPANY_LOGO_PRINT', 'firmenlogo_druck.jpg');
define('REMEMBER_LOGIN_INFO', 'Benutzerkonto speichern ');
	
//images projekte, kontakt
define('IMAGE_PROJECTS', 'Projekte.jpg');
define('IMAGE_CONTACTS', 'Kontaktverwaltung.jpg');

//Monatsnamen
define('JANUARY', 'Januar');
define('FEBRUARY', 'Februar');
define('MARCH', 'M&auml;rz');
define('APRIL', 'April');
define('MAY', 'Mai');
define('JUNE', 'Juni');
define('JULY', 'Juli');
define('AUGUST', 'August');
define('SEPTEMBER', 'September');
define('OCTOBER', 'Oktober');
define('NOVEMBER', 'November');
define('DECEMBER', 'Dezember');

//Monatsnamen 3 chars für Zeitplan
define('JANUARY_SHORT', 'Jan');
define('FEBRUARY_SHORT', 'Feb');
define('MARCH_SHORT', 'M&auml;r');
define('APRIL_SHORT', 'Apr');
define('MAY_SHORT', 'Mai');
define('JUNE_SHORT', 'Jun');
define('JULY_SHORT', 'Jul');
define('AUGUST_SHORT', 'Aug');
define('SEPTEMBER_SHORT', 'Sep');
define('OCTOBER_SHORT', 'Okt');
define('NOVEMBER_SHORT', 'Nov');
define('DECEMBER_SHORT', 'Dez');

//Wochentage 2 chars
define('SUNDAY', 'So');
define('MONDAY', 'Mo');
define('TUESDAY', 'Di');
define('WEDNESDAY', 'Mi');
define('THURSDAY', 'Do');
define('FRIDAY', 'Fr');
define('SATURDAY', 'Sa');

//Wochentage full
define('SUNDAY_LONG', 'Sonntag');
define('MONDAY_LONG', 'Montag');
define('TUESDAY_LONG', 'Dienstag');
define('WEDNESDAY_LONG', 'Mittwoch');
define('THURSDAY_LONG', 'Donnerstag');
define('FRIDAY_LONG', 'Freitag');
define('SATURDAY_LONG', 'Samstag');

// Alerts
define('ALERT_CHANGES_NOT_SAVED', 'Ihre aktuellen Änderungen wurden noch nicht gespeichert!\nDaten jetzt speichern?');
define('ALERT_DELETE', 'Möchten Sie die Daten wirklich löschen?');
define('ALERT_ZEITPLAN', "%s ist in Verzug oder wurde verschoben. Wollen Sie die Daten von %s abgleichen?");
define('ALERT_PROJECT_MOVE_ALL', "Wollen Sie alle Starttermine an das neue Startdatum anpassen?");
define('ALERT_PHASE_MOVE_ALL', "Wollen Sie die Termine aller abhängigen Abschnitte anpassen?");
define('ALERT_PHASE_MOVE', "%s ist abhängig von %s. Wollen Sie die Daten abgleichen?");
define('ALERT_NO_TITLE', "Kein Titel vergeben");

//Messages
define('MESSAGE_CREATED_SUCCESS', 'Daten wurden erfolgreich<br>angelegt');
define('MESSAGE_DELETE_SUCCESS', 'Daten wurden erfolgreich<br>gel&ouml;scht');
define('MESSAGE_NO_ATTACHMENT', 'Sie haben keinen Eintrag unter Dokument/Anhang!<br>Ihre Vorlage kann ohne Anhang nicht gespeichert werden.<br><a href="javascript:history.back();">zur&uuml;ck</a>');

//Newsticker
define('MESSAGE_PROJECT_END', 'Projektende am');

//Newscircle
define('NEWSCIRCLE_PROJECT', '"<b>%s</b>" wurde um %s Uhr von %s auf den Leistungsstatus "<b>%s</b>" gesetzt.');
define('NEWSCIRCLE_PROJECT_PHASE', '"<b>%s %s</b>" wurde um %s Uhr von %s ge&auml;ndert. ');
define('NEWSCIRCLE_TASKS','<b>Zielsetzung:</b> %s - ist <b>%s</b><br><br>');
define('NEWSCIRCLE_NEW_TASKS','<b>Zielsetzung:</b> %s - wurde neu hinzugef&uuml;gt und ist <b>%s</b><br><br>');

//Tasks Email
define('TASK_DONE','Die Aufgabe "<b>%s</b>" wurde von %s am %s um %s Uhr <b>%s</b><br><br>');

// Links aktuell und archiv
	define('TITLE_AKTUELL', 'aktuell');
	define('TITLE_ARCHIV', 'archiv');

// Titel der Module in der Navigation
	define('TITLE_MODUL_BASISDATEN', 'basisdaten');
	define('TITLE_MODUL_BESPRECHUNG', 'protokoll');
	define('TITLE_MODUL_ZEITPLAN', 'zeitplan');
	define('TITLE_MODUL_DOKUMENTE', 'dokument');
	define('TITLE_MODUL_STATISTIK', 'statistik');
	define('TITLE_MODUL_NEU', 'team');
	define('TITLE_MODUL_NEU2', 'controlling');

//Kommunikation Links
	define('TITLE_MENU_LOGOUT', 'logout');
	define('TITLE_MENU_LOGOUT_DESC', 'Plattform verlassen');
	define('TITLE_MENU_SEARCH', 'suchen');
	define('TITLE_MENU_SEARCH_DESC', 'Begriffe suchen');
	define('TITLE_MENU_WEITERLEITEN', 'versand');
	define('TITLE_MENU_WEITERLEITEN_DESC', 'Inhalt versenden');
	define('TITLE_MENU_RUECKMELDUNG', 'email');
	define('TITLE_MENU_RUECKMELDUNG_DESC', 'Emailkommunikation');
	define('TITLE_MENU_DRUCKEN', 'drucken');
	define('TITLE_MENU_DRUCKEN_DESC', 'Inhalt drucken');
//Kommunikation Fenster

	define('SEARCH_TERM', 'Begriff:');
	define('SEARCH_IN', 'Suche in:');
	define('SEARCH_RESULTS', 'Ergebnisliste:');
	define('SEARCH_SEARCH', 'suchen');
	define('SEARCH_CANCEL', 'schlie&szlig;en');
	define('SEARCH_MESSAGE_TERM', 'Bitte geben Sie einen Suchbegriff ein');
	define('SEARCH_MESSAGE_NO_RESULTS', 'Es wurden keine Treffer gefunden');

	define('TRANSFER_EMAIL_TO', 'Inhalt als Email an:');
	define('TRANSFER_FAX_TO', 'Inhalt als FAX an:');
	define('TRANSFER_SEND', 'senden');
	define('TRANSFER_CANCEL', 'schlie&szlig;en');

	define('MAILING_EMAIL', 'Email erstellen');
	define('MAILING_CALLBACK', 'R&uuml;ckmeldung anfordern ');
	define('MAILING_INTERNAL_MESSAGE', 'Interne Kurznachricht erstellen ');
	define('MAILING_CANCEL', 'schlie&szlig;en');
// Mailing Fenster
	define('MAILING_WINDOW_EMAIL', 'Email');
	define('MAILING_WINDOW_CALLBACK', 'R&uuml;ckmeldung');
	define('MAILING_WINDOW_INTERNAL_MESSAGE', 'Kurznachricht');
	define('MAILING_WINDOW_TO', 'an:');
	define('MAILING_WINDOW_FROM', 'von:');
	define('MAILING_WINDOW_UNDER', 'unter:');
	define('MAILING_WINDOW_BCC', 'bcc:');
	define('MAILING_WINDOW_SUBJECT', 'Betreff:');
	define('MAILING_WINDOW_ON', 'am:');
	define('MAILING_WINDOW_AT', 'um:');
	define('MAILING_WINDOW_NOW', 'sofort');
	define('MAILING_WINDOW_DOCUMENT', 'Dokument/Anhang:');
	define('MAILING_WINDOW_ATTACH_DOCUMENT', 'Anhang anlegen:');
	define('MAILING_WINDOW_COPY_TO_SENDER', 'Kopie an aktuellen Benutzer');
	define('MAILING_WINDOW_SAVE_EMAIL', 'im Modul Post archivieren');
	define('MAILING_WINDOW_SAVE_CALLBACK', 'im Modul Post archivieren');
	define('MAILING_WINDOW_SEND', 'senden');
	define('MAILING_WINDOW_CANCEL', 'abbrechen');
// Mailing Messages
	define('MAILING_FROM', 'Absender/Name:');
	define('MAILING_SUBJECT', 'Betreff:');
	define('MAILING_CALLBACK_SUBJECT', 'R&uuml;ckmeldung/Themenkreis:');
	$unter = ''; $um = ''; $datum = '';
	define('MAILING_CALLBACK_MESSAGE', "Ich ersuche Sie um Ihre R&uuml;ckmeldung unter dem Kontakt: $unter. Die R&uuml;ckmeldung ersuche ich ab $datum ($um Uhr) zu t&auml;tigen.<p>Danke.</p>");
	define('MAILING_MESSAGE_VON', 'von');
	define('MAILING_MESSAGE_ON_FROM_AT', 'am/von/um');
	define('MAILING_MESSAGE_READ', 'gelesen');
	
	
define('CREATED_BY_ON', 'creation date:');
define('EDITED_BY_ON', 'last changed:');



?>