<?php
// PROTOCOL
$protocol = "https://";
if ($protocol == "https://" && strtolower(@$_SERVER['HTTPS']) != 'on') {
    $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header("Location: $redirect");
}

/* -------------------------------------------------------------------------
* INC PATH AND INC FOLDER
* -------------------------------------------------------------------------*/
//$path = '/home/dev/public_html';
define("CO_INC_PATH", "/home/dev/public_html");
set_include_path(get_include_path() . PATH_SEPARATOR . CO_INC_PATH);
include('version.php');
define("CO_INC", $co_app_version);

// FILES PATH
define("CO_FILES", $protocol . "dev.companyobserver.com/" . $co_files_version);
define("CO_FILES_NOHTTPS", "http://dev.companyobserver.com/" . $co_files_version);

// product variant: 0 = CO, 1 = Physio, 2 = Therapy
define("CO_PRODUCT_VARIANT", 2);
// PO compat (if true show old treatments without calendar)
define("CO_PHYSIO_COMBAT", false);

// if uncommented use a different img and wording for sketches Bodychart
define("CO_PATIENT_SKETCHES_CUSTOM", "Testing");

define("CO_INVOICE_START", 1000);

// Bodychart background
//define("CO_PHYSIO_BODYCHART_WHITE", true );

/* -------------------------------------------------------------------------
* Database Configuration
* -------------------------------------------------------------------------*/
define("CO_DB_SERVER", "localhost");
define("CO_DB_USERNAME", "");
define("CO_DB_PASSWORD", "");
define("CO_DB_DATABASE", "");

/* -------------------------------------------------------------------------
* Global Site Settings
* -------------------------------------------------------------------------*/
define("CO_PATH_BASE", "/home/dev/public_html");
define("CO_PATH_URL", $protocol . "dev.companyobserver.com");

define("CO_LICENSE", "communautic KG");

/* Default Language */
define("CO_DEFAULT_LANGUAGE", "de");
define("CO_DEFAULT_TIMEZONE", "Europe/Vienna");
date_default_timezone_set('UTC');

/* -------------------------------------------------------------------------
* Settings for Invoice Reminder Days
* -------------------------------------------------------------------------*/
define("CO_DEFAULT_CURRENCY", '€');
define("CO_INVOICE_REMINDER_DAYS", 30);
define("CO_INVOICE_FOOTER", "Konto: Raika Hall Regionalbank | BLZ: 36362 | Kontonummer: 120824");

/* -------------------------------------------------------------------------
* Settings for Module Trainings if installed
* -------------------------------------------------------------------------*/

define("CO_TRAININGS_COMPANY_NAME", "Recheis Akademie");
define("CO_TRAININGS_COMPANY_EMAIL", "lisa.wenk@recheis.com");

// Data folder
define("CO_PATH_DATA", CO_PATH_BASE . "/data/");
define("CO_PATH_DOCUMENTS", CO_PATH_BASE . "/data/documents/");
define("CO_PATH_CHARTS", CO_PATH_BASE . "/data/charts/");
define("CO_PATH_PDF", CO_PATH_BASE . "/data/pdf/");
define("CO_PATH_TEMPLATES", CO_PATH_BASE . "/data/templates/");

/* Upload Folders */
//define("PO_PATH_DATA"	, CO_PATH_BASE . "/data/");
define("PO_MAX_FILESIZE", 1024*1024*8);

$doc_extensions = array(".png", ".zip", ".pdf", ".jpg");
define("PO_DOCUMENTS_EXTENSIONS", serialize($doc_extensions));
$img_extensions = array(".jpg", ".gif", ".png");
define("PO_IMAGES_EXTENSIONS", serialize($img_extensions));

define("PO_PATH_IMAGES", CO_PATH_BASE . "/data/images/");

/* -------------------------------------------------------------------------
* Advanced Database/Table Settings
* -------------------------------------------------------------------------*/
define("TBL_PREFIX", "co_");
define("CO_TBL_USER_SETTINGS", TBL_PREFIX . "users_settings");
define("CO_TBL_USERS", TBL_PREFIX . "users");
define("CO_TBL_ACTIVE_USERS", TBL_PREFIX . "active_users");
define("CO_TBL_ACTIVE_GUESTS", TBL_PREFIX . "active_guests");
define("CO_TBL_BANNED_USERS", TBL_PREFIX . "banned_users");

//putenv("TZ=Europe/Vienna");
//date_default_timezone_set('Europe/Vienna');
define("CO_DATE_FORMAT", "d.m.Y");
define("CO_DATETIME_FORMAT", "d.m.Y H:i");
define("CO_TIME_FORMAT", "H:i");

/**
 * Special Names and Level Constants - the admin
 * page will only be accessible to the user with
 * the admin name and also to those users at the
 * admin user level. Feel free to change the names
 * and level constants as you see fit, you may
 * also add additional level specifications.
 * Levels must be digits between 0-9.
 */
define("SYSADMIN_NAME", "sysadmin");
//define("ADMIN_NAME", "generaladmin");
define("GUEST_NAME", "Guest");
define("SYSADMIN_LEVEL", 1);
//define("ADMIN_LEVEL", 2);
//define("USER_LEVEL",  3);
define("GUEST_LEVEL", 0);

define("TRACK_VISITORS", true);
define("USER_TIMEOUT", 60);
define("GUEST_TIMEOUT", 60);
define("COOKIE_EXPIRE", 60*60*24*100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain
define("EMAIL_FROM_NAME", "YourName");
define("EMAIL_FROM_ADDR", "youremail@address.com");
define("EMAIL_WELCOME", false);
define("ALL_LOWERCASE", false);

define("PASSWORDSALT", '6a67a466cb3ede6e947f55831f90f5');
