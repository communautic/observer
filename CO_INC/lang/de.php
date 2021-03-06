<?php
switch(CO_PRODUCT_VARIANT) {
	case 0:
		$lang["APPLICATION_NAME"] = "company observer 7.0.6";
		$lang["APPLICATION_NAME_ALT"] = "company.observer";
		$lang["APPLICATION_NAME_CAPS"] = "Company Observer";
		$lang["APPLICATION_LOGO"] = "company_observer.png";
		$lang["APPLICATION_LOGO_LOGIN"] = "company_observer_login.png";
		$lang["APPLICATION_WEBSITE"] = "http://companyobserver.at";
		$lang["APPLICATION_SUPPORT_EMAIL"] = "support@companyobserver.com";
		$GLOBALS["APPLICATION_LOGO_PRINT"] = "poweredby_company_observer.png";
	break;
	case 1:
		$lang["APPLICATION_NAME"] = "physio observer 7.0.6";
		$lang["APPLICATION_NAME_ALT"] = "physio.observer";
		$lang["APPLICATION_NAME_CAPS"] = "Physio Observer";
		$lang["APPLICATION_LOGO"] = "physio_observer.png";
		$lang["APPLICATION_LOGO_LOGIN"] = "physio_observer_login.png";
		$lang["APPLICATION_WEBSITE"] = "http://physioobserver.at";
		$lang["APPLICATION_SUPPORT_EMAIL"] = "support@physioobserver.at";
		$GLOBALS["APPLICATION_LOGO_PRINT"] = "poweredby_physio_observer.png";
	break;
	case 2:
		$lang["APPLICATION_NAME"] = "therapy observer 7.0.6";
		$lang["APPLICATION_NAME_ALT"] = "therapy.observer";
		$lang["APPLICATION_NAME_CAPS"] = "Therapy Observer";
		$lang["APPLICATION_LOGO"] = "therapy_observer.png";
		$lang["APPLICATION_LOGO_LOGIN"] = "therapy_observer_login.png";
		$lang["APPLICATION_WEBSITE"] = "http://therapyobserver.at";
		$lang["APPLICATION_SUPPORT_EMAIL"] = "support@therapyobserver.at";
		$GLOBALS["APPLICATION_LOGO_PRINT"] = "poweredby_therapy_observer.png";
	break;
}

setlocale(LC_TIME, "de_DE");

/* LOGIN PAGE */
$lang["LOGIN_USERNAME"] = "Benutzername";
$lang["LOGIN_PASSWORD"] = "Passwort";
$lang["LOGIN_PASSWORD_REPEAT"] = "Passwort wiederholen";
$lang["LOGIN_SET_LOGIN"] = 'Bitte geben Sie als erstes im dafür vorgesehen weißen Feld den von Ihnen gewünschten, neuen Benutzernamen ein (mindestens 6 Zeichen, Unterscheidung zwischen Groß- und Kleinschreibung). Anschließend geben Sie Ihr neues Passwort ein (ebenfalls mindestens 6 Zeichen, inkl. der Möglichkeit Sonderzeichen zu verwenden). Wiederholen Sie aus Sicherheitsgründen die Passworteingabe und schließen Sie den Vorgang ab, indem Sie auf "bestätigen" klicken.';
$lang["LOGIN_REMEMBER"] = "Benutzerkonto speichern";
$lang["LOGIN_REQUIREMENTS"] = "Systemanforderungen";
$lang["LOGIN_REQUIREMENTS_DETAILS"] = "Internet Explorer 6+, Firefox 2+, Safari3+";
$lang["LOGIN_LOGIN"] = "weiter";
$lang["LOGIN_CONFIRM"] = "bestätigen";
$lang["LOGIN_COPYRIGHT"] = '<a href="http://www.communautic.com" target="_blank">Alle Rechte vorbehalten communautic Ebenbichler KG | www.communautic.com</a>';
$lang["LOGIN_LOGIN_FAILED"] = "Benutzername oder Passwort sind nicht korrekt. Bitte versuchen Sie es erneut.";
$lang["LOGIN_LOGOUT"] = "Abmelden";
$lang["LOGIN_HELP"] = 'manual_login.pdf';
$lang["LOGIN_TERMS"] = 'Produktnutzungsbestimmungen (AGB)';
$lang["LOGIN_TERMS_FILE"] = 'CO_PO_AGB_2013.pdf';

/* APPS ACTION LINKS */
$lang["ACTION_CLOSE"] = "zuklappen";
$lang["ACTION_NEW"] = "neu";
$lang["ACTION_IMPORT"] = "importieren";
$lang["ACTION_PRINT"] = "drucken";
$lang["ACTION_SENDTO"] = "weiterleiten";
$lang["ACTION_DUPLICATE"] = "duplizieren";
$lang["ACTION_REFRESH"] = "aktualisieren";
$lang["ACTION_EXPORT"] = "exportieren";
$lang["ACTION_ARCHIVE_DUPLICATE"] = "duplizieren";
$lang["ACTION_MOVETO_ARCHIVE"] = "archivieren";
$lang["ACTION_ARCHIVE_REVIVE"] = "aktivieren";
$lang["ACTION_HELP"] = "Hilfe aufrufen";
$lang["ACTION_DELETE"] = "löschen";

$lang["TEXT_NOTE"] = "";
	
$lang["CREATED_BY_ON"]		= 	'angelegt:';
$lang["EDITED_BY_ON"] 		= 	'aktualisiert:';
$lang["CREATED_BY_ON"]		= 	'angelegt:';
$lang["ARCHIVED_BY_ON"] 	= 	'archiviert:';
$lang["READ_BY_ON"] 		= 	'gelesen von:';
$lang["SENDTO_BY_ON"] 		= 	'weitergeleitet an:';
$lang["SENDFROM_BY_ON"] 	= 	'erhalten von:';
$lang["DELETED_BY_ON"] 		= 	'gelöscht';
$lang["INTERNAL_CHANGED"] 	= 	'freigegeben:';

$lang["GLOBAL_MODULE"] = 'Module';
$lang["GLOBAL_METATAGS"] = 'Metatags';
$lang["GLOBAL_FOLDERS"] = 'Ordner';
$lang["GLOBAL_USER"] = 'Benutzer:';
$lang["GLOBAL_ADMIN"] = 'Administrator';
$lang["GLOBAL_ADMIN_SHORT"] = 'Admin';
$lang["GLOBAL_ADMINS"] = 'Administratoren';
$lang["GLOBAL_GUEST"] = 'Beobachter';
$lang["GLOBAL_GUEST_SHORT"] = 'Beob';
$lang["GLOBAL_GUESTS"] = 'Beobachter';
$lang["GLOBAL_OWNER"] = 'Ersteller';

$lang["GLOBAL_SAVE"] = 'Speichern';
$lang["GLOBAL_DELETE"] = 'Löschen';
$lang["GLOBAL_RESET"] = 'Zurücksetzen';
$lang["GLOBAL_CONFIRM"] = 'Bestätigen';
$lang["GLOBAL_SENDEMAIL"] = 'Versenden';
$lang["GLOBAL_EDIT"] = 'Bearbeiten';
$lang["GLOBAL_SETTINGS"] = 'Einstellungen';

$lang["GLOBAL_TITLE"] = 'Titel';
$lang["GLOBAL_RESPONSIBILITY"] = 'Verantwortung';
$lang["GLOBAL_DESCRIPTION"] = 'Beschreibung';

$lang["GLOBAL_YES"] = 'ja';
$lang["GLOBAL_NO"] = 'nein';
$lang['GLOBAL_CURRENCY_POUND'] = '£';
$lang['GLOBAL_CURRENCY_DOLLAR'] = '$';
$lang['GLOBAL_CURRENCY_EURO'] = '€';
$lang['GLOBAL_CURRENCY'] = 'Währung';
$lang['GLOBAL_COSTS'] = 'Kosten';
$lang['GLOBAL_COSTS_EMPLOYEES'] = 'Personalkosten';
$lang['GLOBAL_COSTS_MATERIAL'] = 'Materialkosten';
$lang['GLOBAL_COSTS_EXTERNAL'] = 'Fremdleistungen';
$lang['GLOBAL_COSTS_OTHER'] = 'Sonstige Kosten';
$lang['GLOBAL_COSTS_EMPLOYEES_SHORT'] = 'Personal';
$lang['GLOBAL_COSTS_MATERIAL_SHORT'] = 'Material';
$lang['GLOBAL_COSTS_EXTERNAL_SHORT'] = 'Fremd';
$lang['GLOBAL_COSTS_OTHER_SHORT'] = 'Sonstige';

$lang["GLOBAL_STATUS"] 		= 	'Status';
// Status definitions
$lang["GLOBAL_STATUS_PLANNED"] = 'in Planung';
$lang["GLOBAL_STATUS_PLANNED_TIME"] = 'seit';
$lang["GLOBAL_STATUS_INPROGRESS"] = 'in Arbeit';
$lang["GLOBAL_STATUS_INPROGRESS_TIME"] = 'seit';
$lang["GLOBAL_STATUS_FINISHED"] = 'abgeschlossen';
$lang["GLOBAL_STATUS_FINISHED_TIME"] = 'am';
$lang["GLOBAL_STATUS_STOPPED"] = 'abgebrochen';
$lang["GLOBAL_STATUS_STOPPED_TIME"] = 'am';
// timelines
$lang["GLOBAL_STATUS_NOT_FINISHED"] = "nicht abgeschlossen";
$lang["GLOBAL_STATUS_OVERDUE"] = "außer Plan";
$lang["GLOBAL_STATUS_OVERDUE_POPUP"] = "Tag/e außer Plan";
// meetings
$lang["GLOBAL_STATUS_COMPLETED"] = 'abgehalten';
$lang["GLOBAL_STATUS_COMPLETED_TIME"] = 'am';
$lang["GLOBAL_STATUS_CANCELLED"] = 'abgesagt';
$lang["GLOBAL_STATUS_CANCELLED_TIME"] = 'am';
$lang["GLOBAL_STATUS_POSPONED"] = 'verschoben';
$lang["GLOBAL_STATUS_POSPONED_TIME"] = 'auf';
// forums
$lang["GLOBAL_STATUS_DISCUSSION"] = 'in Diskussion';
$lang["GLOBAL_STATUS_DISCUSSION_TIME"] = 'seit';
// complaints
$lang["GLOBAL_STATUS_ENTERED"] = 'erfasst';
$lang["GLOBAL_STATUS_ENTERED_TIME"] = 'am';
// webnews
$lang["GLOBAL_STATUS_PUBLISHED"] = 'publiziert';
$lang["GLOBAL_STATUS_PUBLISHED_TIME"] = 'seit';
$lang["GLOBAL_STATUS_ARCHIVED"] = 'archiviert';
$lang["GLOBAL_STATUS_ARCHIVED_TIME"] = 'seit';
// employees
$lang["GLOBAL_STATUS_TRIAL"] = 'in Probe';
$lang["GLOBAL_STATUS_TRIAL_TIME"] = 'seit';
$lang["GLOBAL_STATUS_ACTIVE"] = 'aktiv';
$lang["GLOBAL_STATUS_ACTIVE_TIME"] = 'seit';
$lang["GLOBAL_STATUS_MATERNITYLEAVE"] = 'karenziert';
$lang["GLOBAL_STATUS_MATERNITYLEAVE_TIME"] = 'seit';
$lang["GLOBAL_STATUS_LEAVE"] = 'ausgeschieden';
$lang["GLOBAL_STATUS_LEAVE_TIME"] = 'am';
// evals
$lang["GLOBAL_STATUS_INPREPARATION"] = 'in Vorbereitung';
$lang["GLOBAL_STATUS_INPREPARATION_TIME"] = 'seit';
$lang["GLOBAL_STATUS_FIRSTEVAL"] = 'Erstanalyse';
$lang["GLOBAL_STATUS_FIRSTEVAL_TIME"] = 'am';
$lang["GLOBAL_STATUS_INEVALUATION"] = 'in Evaluierung';
$lang["GLOBAL_STATUS_INEVALUATION_TIME"] = 'seit';
// trainings
$lang["GLOBAL_STATUS_INACTION"] = 'in Ausführung';
$lang["GLOBAL_STATUS_INACTION_TIME"] = 'seit';
$lang["GLOBAL_STATUS_FINISHED2"] = 'abgehalten';
$lang["GLOBAL_STATUS_FINISHED2_TIME"] = 'seit';

$lang["GLOBAL_DURATION"] 	= 	'Dauer';
$lang["GLOBAL_EMAILED_TO"] 	= 	'Weiterleitung';
$lang["GLOBAL_DUPLICAT"] 	= 	'Duplikat';

$lang["GLOBAL_ACCESS"] = 'Beobachter';
$lang["GLOBAL_ACCESS_INTERNAL"] = 'nicht freigegeben';
$lang["GLOBAL_ACCESS_PUBLIC"] = 'freigegeben';
$lang["GLOBAL_ACCESS_FOOTER"] = 'freigegeben:';
$lang["GLOBAL_FOOTER_STATUS"] = 'Stand';

$lang["GLOBAL_FORWARD"] = 'Weiterleitung';
$lang["GLOBAL_TO"] = 'An';
$lang["GLOBAL_CC"] = 'CC';
$lang["GLOBAL_BCC"] = 'BCC';
$lang["GLOBAL_SUBJECT"] = 'Betreff';
$lang["GLOBAL_MESSAGE"] = 'Inhalt';
$lang["GLOBAL_SEND"] = 'Senden';
$lang["GLOBAL_EXPORT"] = 'Exportieren';

$lang["GLOBAL_CHECKPOINT"] = 'Checkpoint';

$lang["GLOBAL_DAYS"] = 'Tage';
$lang["GLOBAL_TODAY"] = 'Heute';
$lang["GLOBAL_YESTERDAY"] = 'Gestern';
$lang["GLOBAL_DAYS_AGO"] = 'vor %1$s Tagen';
$lang["GLOBAL_WEEK_SHORT"] = 'KW';
$lang["GLOBAL_TIME_FROM"] = 'von';
$lang["GLOBAL_TIME_TO"] = 'bis';

$lang["GLOBAL_GENDER_MALE"] = 'männlich';
$lang["GLOBAL_GENDER_FEMALE"] = 'weiblich';

$lang["GLOBAL_ALERT"] = 'Warnung';
$lang["GLOBAL_CONTENT_EDITED_BY"] = 'Dieser Inhaltsbereich wird aktuell bearbeitet von:';

// email footer
$lang["GLOBAL_EMAIL_FOOTER"] = 	'<p style="font-face: Arial, Verdana; font-size:small; color: #999999;">_____powered by '.$lang["APPLICATION_NAME_ALT"].'</p>' .
								'<p style="font-face: Arial, Verdana; font-size:x-small; color: #999999;">Dieses E-Mail und der Inhalt sind vertraulich und ausschließlich für den (die) bezeichneten Adressaten bestimmt. Wenn Sie nicht der genannte Adressat sind, darf dieses E-Mail von Ihnen weder anderen Personen zugänglich gemacht, noch kopiert, weitergegeben oder zurückbehalten werden. Diese Information kann durch gesetzliche Vorschriften besonders geschützt oder privilegiert sein. Wenn Sie nicht der beabsichtigte Empfänger sind, bitten wir Sie, uns umgehend zu informieren, dieses E-Mail und sämtliche darin enthaltenen Informationen zu löschen und von jeder anderen Handlung im Hinblick auf dieses E-Mail abzusehen.</p>';

// PDF print Globals
$GLOBALS['SECTION'] = "";
$GLOBALS['PAGE'] = "Seite";
$GLOBALS['OF'] = "von"; 
?>